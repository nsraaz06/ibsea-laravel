<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\MembershipPlan;
use App\Models\EventTicket;

class CouponController extends Controller
{
    /**
     * Apply a coupon code and return its details.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'type' => 'required|in:Membership,Event',
            'item_id' => 'required',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code.'
            ], 422);
        }

        // Get the item amount
        $amount = 0;
        if ($request->type === 'Membership') {
            $plan = MembershipPlan::find($request->item_id);
            $amount = $plan ? $plan->fee_numeric : 0;
        } else {
            $ticket = EventTicket::find($request->item_id);
            if ($ticket) {
                $today = now();
                $has_offer = (!empty($ticket->offer_price) && $ticket->offer_price > 0);
                $is_offer_valid = $has_offer && (empty($ticket->last_date_to_buy) || $today->lte($ticket->last_date_to_buy));
                $amount = $is_offer_valid ? $ticket->offer_price : $ticket->original_price;
            }
        }

        // Validate the coupon
        [$isValid, $message] = $coupon->isValid($amount, auth('member')->id());

        if (!$isValid) {
            return response()->json([
                'success' => false,
                'message' => $message
            ], 422);
        }

        $discount = $coupon->calculateDiscount($amount);
        $final_amount = max(0, $amount - $discount);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'coupon_id' => $coupon->id,
            'discount' => $discount,
            'final_amount' => $final_amount,
            'type' => $coupon->type,
            'value' => $coupon->value
        ]);
    }
}
