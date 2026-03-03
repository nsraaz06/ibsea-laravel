<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\EventTicket;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Member;
use App\Models\EventBooking;
use App\Notifications\WelcomeGuestMember;
use Illuminate\Support\Facades\Password;
use App\Models\Coupon;

class PaymentController extends Controller
{
    /**
     * Show the separate checkout page.
     */
    public function checkout(Request $request)
    {
        $type = $request->type; // 'Membership' or 'Event'
        $item_id = $request->item_id;
        
        $item_name = "Subscription";
        $amount = 0;
        $currency_symbol = '₹';

        if ($type === 'Membership') {
            $plan = MembershipPlan::findOrFail($item_id);
            $item_name = $plan->title . " Membership";
            $amount = $plan->fee_numeric;
            $currency_symbol = $plan->currency_symbol ?? '₹';
        } else {
            $ticket = EventTicket::findOrFail($item_id);
            $item_name = $ticket->ticket_name . " | " . $ticket->event->name;
            
            $today = now();
            $has_offer = (!empty($ticket->offer_price) && $ticket->offer_price > 0);
            $is_offer_valid = $has_offer && (empty($ticket->last_date_to_buy) || $today->lte($ticket->last_date_to_buy));
            $amount = $is_offer_valid ? $ticket->offer_price : $ticket->original_price;
            
            // Assuming tickets are INR for now, or add currency to tickets later
            $currency_symbol = '₹';
        }

        $user = auth('member')->user();
        
        $can_use_pass = false;
        $pass_error = null;
        $remaining_passes = 0;

        if ($type === 'Event' && $user) {
            $ticket = EventTicket::findOrFail($item_id);
            [$can_use_pass, $pass_error] = $user->canUsePassOnTicket($ticket);
            $remaining_passes = $user->remainingPassesCount();
        }

        return view('payments.checkout', [
            'title' => 'Secure Checkout | IBSEA',
            'type' => $type,
            'item_id' => $item_id,
            'item_name' => $item_name,
            'amount' => $amount,
            'currency_symbol' => $currency_symbol,
            'user' => $user,
            'can_use_pass' => $can_use_pass,
            'pass_error' => $pass_error,
            'remaining_passes' => $remaining_passes
        ]);
    }

    /**
     * Initiate payment for Event Ticket or Membership Subscription.
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Membership,Event',
            'item_id' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:15',
        ]);

        $settings = \App\Models\SiteSetting::all()->pluck('value', 'key');
        $active_gateway = $settings['active_payment_gateway'] ?? 'cashfree';
        $payment_mode = $settings['payment_mode'] ?? 'SANDBOX';

        $type = $request->type;
        $item_id = $request->item_id;
        $name = $request->name;
        $email = $request->email;
        $mobile = $request->mobile;

        $amount = 0;
        $currency = 'INR';
        $item_name = 'Subscription';

        if ($type === 'Membership') {
            $plan = MembershipPlan::findOrFail($item_id);
            $amount = $plan->fee_numeric;
            $currency = $plan->currency ?? 'INR';
            $item_name = $plan->title . " Membership";
        } else {
            $ticket = EventTicket::findOrFail($item_id);
            $today = now();
            $has_offer = (!empty($ticket->offer_price) && $ticket->offer_price > 0);
            $is_offer_valid = $has_offer && (empty($ticket->last_date_to_buy) || $today->lte($ticket->last_date_to_buy));
            $amount = $is_offer_valid ? $ticket->offer_price : $ticket->original_price;
            
            $currency = 'INR';
            $item_name = $ticket->ticket_name . " | " . $ticket->event->name;
        }

        // Handle Guest/Member mapping EARLIER for Coupon Validation
        $member_id = auth('member')->id();
        if (!$member_id) {
            $member = Member::where('email', $email)->orWhere('mobile', $mobile)->first();
            if (!$member) {
                $member = Member::create([
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'role_id' => 2, // Default 'Member' role
                    'status' => 'Active',
                    'profile_completed' => 0,
                ]);
            }
            $member_id = $member->id;
            auth('member')->login($member);
        } else {
            $member = auth('member')->user();
        }

        // Handle Coupon Logic (Now we have member_id for guest users too)
        $coupon_id = null;
        $discount_amount = 0;
        $is_pass_usage = false;

        if ($type === 'Event' && $request->use_membership_pass && $member) {
            $ticket = EventTicket::findOrFail($item_id);
            [$can_use, $error] = $member->canUsePassOnTicket($ticket);
            if ($can_use) {
                $amount = 0;
                $is_pass_usage = true;
            } else {
                return back()->with('error', $error);
            }
        } elseif ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->where('status', 'Active')->first();
            if ($coupon) {
                [$isValid, $msg] = $coupon->isValid($amount, $member_id);
                if ($isValid) {
                    $coupon_id = $coupon->id;
                    $discount_amount = $coupon->calculateDiscount($amount);
                    $amount = max(0, $amount - $discount_amount);
                }
            }
        }

        // Handle Referral Logic
        $referrerId = null;
        if ($request->referral_code) {
            $referrer = Member::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referrerId = $referrer->id;
                if (!$member->referrer_id) {
                    $member->update(['referrer_id' => $referrerId]);
                    Member::where('id', $referrerId)->increment('referral_count');
                }
            }
        }

        $order_id = "IBSEA_" . strtoupper(substr($type, 0, 3)) . "_" . time();

        // Check for 0-amount (Membership Pass or 100% Coupon)
        if ($amount <= 0 && ($is_pass_usage || $discount_amount > 0)) {
            $payment = Payment::create([
                'member_id' => $member_id,
                'amount' => 0,
                'currency' => $currency,
                'payment_type' => $type,
                'item_id' => $item_id,
                'cashfree_order_id' => $order_id,
                'status' => 'Success',
                'gateway' => $is_pass_usage ? 'membership_pass' : 'coupon_full',
                'coupon_id' => $coupon_id,
                'discount_amount' => $discount_amount
            ]);

            // Full Success Processing Path
            DB::transaction(function () use ($payment, $is_pass_usage) {
                if ($payment->payment_type === 'Event') {
                    $ticket = EventTicket::findOrFail($payment->item_id);
                    EventBooking::create([
                        'member_id' => $payment->member_id,
                        'event_id' => $ticket->event_id,
                        'ticket_id' => $ticket->id,
                        'payment_id' => $payment->id,
                        'is_pass_usage' => $is_pass_usage,
                        'pass_source' => $is_pass_usage ? $payment->member->membershipPlan?->title : null,
                        'status' => 'Confirmed',
                        'secret_token' => Str::random(32)
                    ]);
                    if ($ticket->ticket_quantity > 0) $ticket->decrement('ticket_quantity');
                } else if ($payment->payment_type === 'Membership') {
                    $plan = MembershipPlan::findOrFail($payment->item_id);
                    $validity = (int)$plan->validity_days ?: 365;
                    $payment->member->update([
                        'membership_end' => Carbon::now()->addDays($validity),
                        'status' => 'Active',
                        'membership_plan_id' => $plan->id
                    ]);
                }
                if ($payment->coupon_id) Coupon::where('id', $payment->coupon_id)->increment('used_count');
            });

            return redirect()->route('home')->with('success', $is_pass_usage ? 'Booking confirmed using Membership Pass!' : 'Order confirmed successfully!');
        }

        if ($active_gateway === 'manual') {
            $form = \App\Models\Form::where('slug', 'payment-inquiry')->first();
            if ($form) {
                \App\Models\FormSubmission::create([
                    'form_id' => $form->id,
                    'member_id' => $member_id,
                    'ip_address' => $request->ip(),
                    'data' => [
                        'full_name' => $name,
                        'email_address' => $email,
                        'whatsapp_number' => $mobile,
                        'purposed_item' => $item_name,
                        'additional_message' => "Automated Inquiry from Checkout Page. Order ID: " . $order_id
                    ]
                ]);
            }

            return view('payments.manual_success', [
                'item_name' => $item_name,
                'order_id' => $order_id,
                'name' => $name,
                'mobile' => $mobile
            ]);
        }

        if ($active_gateway === 'razorpay') {
            $key_id = $settings['razorpay_key_id'] ?? '';
            $key_secret = $settings['razorpay_key_secret'] ?? '';

            if (empty($key_id) || empty($key_secret)) {
                return back()->with('error', 'Razorpay configuration is missing.');
            }

            // Create Razorpay Order
            $response = Http::withBasicAuth($key_id, $key_secret)
                ->post('https://api.razorpay.com/v1/orders', [
                    "amount" => $amount * 100, // Amount in paise
                    "currency" => $currency,
                    "receipt" => $order_id,
                ]);

            if ($response->successful()) {
                $result = $response->json();
                
                Payment::create([
                    'member_id' => $member_id,
                    'amount' => $amount,
                    'currency' => $currency,
                    'payment_type' => $type,
                    'item_id' => $item_id,
                    'cashfree_order_id' => $order_id, // We'll use this field for generic internal order_id
                    'payment_session_id' => $result['id'], // Razorpay Order ID
                    'gateway' => 'razorpay',
                    'coupon_id' => $coupon_id,
                    'discount_amount' => $discount_amount
                ]);

                return view('payments.razorpay', [
                    'key_id' => $key_id,
                    'amount' => $amount * 100,
                    'currency' => $currency,
                    'razorpay_order_id' => $result['id'],
                    'order_id' => $order_id,
                    'item_name' => $item_name,
                    'user_name' => $name,
                    'user_email' => $email,
                    'user_mobile' => $mobile
                ]);
            }

            Log::error('Razorpay Order Initiation Failed', ['response' => $response->body()]);
            $redirectRoute = $type === 'Event' ? route('public.events.show', $item_id) : route('membership');
            return redirect($redirectRoute)->with('error', 'Razorpay initialization failed. Please try again.');

        } else {
            // Cashfree logic
            $app_id = $settings['cashfree_app_id'] ?? config('cashfree.app_id');
            $secret = $settings['cashfree_secret_key'] ?? config('cashfree.secret_key');
            
            // Failsafe: IF test credentials are provided but production is checked, FORCE sandbox URL to prevent 404
            if (str_starts_with(strtoupper($app_id ?? ''), 'TEST')) {
                $payment_mode = 'SANDBOX';
            }
            
            $cf_url = $payment_mode === 'PRODUCTION' ? 'https://api.cashfree.com/pg/orders' : 'https://sandbox.cashfree.com/pg/orders';

            // Create Pending Payment Record
            $payment = Payment::create([
                'member_id' => $member_id,
                'amount' => $amount,
                'currency' => $currency,
                'payment_type' => $type,
                'item_id' => $item_id,
                'cashfree_order_id' => $order_id,
                'status' => 'Failed', 
                'gateway' => 'cashfree',
                'coupon_id' => $coupon_id,
                'discount_amount' => $discount_amount
            ]);

            // Request Payment Session from Cashfree
            $response = Http::withHeaders([
                'x-api-version' => '2022-09-01',
                'x-client-id' => $app_id,
                'x-client-secret' => $secret,
            ])->post($cf_url, [
                "order_amount" => $amount,
                "order_currency" => $currency,
                "order_id" => $order_id,
                "customer_details" => [
                    "customer_id" => "MBR_" . $member_id,
                    "customer_phone" => $mobile,
                    "customer_email" => $email,
                    "customer_name" => $name
                ],
                "order_meta" => [
                    "return_url" => route('payment.verify') . "?order_id={order_id}&gateway=cashfree",
                    "notify_url" => route('payment.webhook')
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $payment->update([
                    'payment_session_id' => $result['payment_session_id']
                ]);

                return view('payments.redirect', [
                    'session_id' => $result['payment_session_id'],
                    'mode' => $payment_mode === 'PRODUCTION' ? 'production' : 'sandbox'
                ]);
            }

            Log::error('Cashfree Payment Initiation Failed', ['response' => $response->body()]);
            
            $redirectRoute = $type === 'Event' ? route('public.events.show', $item_id) : route('membership');
            return redirect($redirectRoute)->with('error', 'Payment gateway initialization failed. Please try again later.');
        }
    }

    /**
     * Verify payment status after redirect.
     */
    public function verify(Request $request)
    {
        $order_id = $request->query('order_id');
        $gateway = $request->query('gateway');

        if (!$order_id) {
            return redirect()->route('home')->with('error', 'Invalid order session.');
        }

        $payment = Payment::where('cashfree_order_id', $order_id)->first();
        if (!$payment) return redirect()->route('home')->with('error', 'Payment record not found.');

        $is_paid = false;
        $settings = \App\Models\SiteSetting::all()->pluck('value', 'key');

        if ($gateway === 'razorpay') {
            $payment_id = $request->query('razorpay_payment_id');
            $signature = $request->query('razorpay_signature');
            $razorpay_order_id = $payment->payment_session_id;

            $key_secret = $settings['razorpay_key_secret'] ?? '';
            
            // Verify Signature
            $expectedSignature = hash_hmac('sha256', $razorpay_order_id . '|' . $payment_id, $key_secret);
            if ($expectedSignature === $signature) {
                $is_paid = true;
            }
        } else {
            // Cashfree verification
            $app_id = $settings['cashfree_app_id'] ?? config('cashfree.app_id');
            $secret = $settings['cashfree_secret_key'] ?? config('cashfree.secret_key');
            $payment_mode = $settings['payment_mode'] ?? 'SANDBOX';
            
            // Failsafe: IF test credentials are provided but production is checked, FORCE sandbox URL to prevent 404
            if (str_starts_with(strtoupper($app_id ?? ''), 'TEST')) {
                $payment_mode = 'SANDBOX';
            }
            
            $cf_url = $payment_mode === 'PRODUCTION' ? 'https://api.cashfree.com/pg/orders/' : 'https://sandbox.cashfree.com/pg/orders/';

            $response = Http::withHeaders([
                'x-api-version' => '2022-09-01',
                'x-client-id' => $app_id,
                'x-client-secret' => $secret,
            ])->get($cf_url . $order_id);

            if ($response->successful()) {
                $result = $response->json();
                if (($result['order_status'] ?? 'FAILED') === 'PAID') {
                    $is_paid = true;
                }
            }
        }

        if ($is_paid) {
            if ($payment->status !== 'Success') {
                DB::transaction(function () use ($payment) {
                    $payment->update(['status' => 'Success']);
                    $member = $payment->member;

                    // Send Welcome Email if Guest (No Password)
                    if ($member && is_null($member->password)) {
                        $token = Password::broker('members')->createToken($member);
                        $member->notify(new WelcomeGuestMember($token));
                    }

                    if ($payment->payment_type === 'Membership') {
                        $plan = MembershipPlan::findOrFail($payment->item_id);
                        
                        $validity = (int)$plan->validity_days;
                        if ($validity <= 0) $validity = 365;

                        $new_end_date = Carbon::now()->addDays($validity);
                        
                        $member->update([
                            'membership_end' => $new_end_date,
                            'status' => 'Active',
                            'membership_plan_id' => $plan->id
                        ]);
                    } else if ($payment->payment_type === 'Event') {
                        $ticket = EventTicket::findOrFail($payment->item_id);
                        
                        EventBooking::create([
                            'member_id' => $payment->member_id,
                            'event_id' => $ticket->event_id,
                            'ticket_id' => $ticket->id,
                            'payment_id' => $payment->id,
                            'status' => 'Confirmed',
                            'secret_token' => Str::random(32)
                        ]);

                        if ($ticket->ticket_quantity > 0) {
                            $ticket->decrement('ticket_quantity');
                        }
                    }

                    // Increment Coupon usage
                    if ($payment->coupon_id) {
                        Coupon::where('id', $payment->coupon_id)->increment('used_count');
                    }
                });
            }
            return redirect()->route('home')->with('success', 'Payment successful!');
        }

        return redirect()->route('home')->with('error', 'Payment verification failed.');
    }

    /**
     * Webhook handler for Cashfree notifications.
     */
    public function webhook(Request $request)
    {
        // Internal webhook processing logic for background verification
        $order_id = $request->input('data.order.order_id');
        if ($order_id && $request->input('data.order.order_status') === 'PAID') {
            // Re-use logic or call verify logic internally
            Log::info('Webhook received for order: ' . $order_id);
        }
        return response('Webhook Handled', 200);
    }
}
