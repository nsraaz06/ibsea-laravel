<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Member extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'leadership_email', 'password', 'mobile', 'whatsapp_no', 'dob', 'profile_image',
        'chapter_id', 'council_id', 'role', 'role_id', 'membership_plan_id', 'membership_start',
        'membership_end', 'address_line', 'city', 'state_country', 'pincode', 'status',
        'strategic_rank', 'alliance_name', 'bio', 'linkedin_url', 'website_url',
        'business_name', 'industry', 'profession', 'business_category',
        'short_description', 'full_description', 'achievements', 'profile_completed', 'setup_token',
        'referrer_id', 'referral_code', 'referral_count', 'membership_id'
    ];

    /**
     * Determine if the member is a guest/unpaid (Restricted Access).
     */
    public function isRestricted()
    {
        return $this->role === 'Member' && empty($this->membership_plan_id);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }

    public function referrer()
    {
        return $this->belongsTo(Member::class, 'referrer_id');
    }

    public function referrals()
    {
        return $this->hasMany(Member::class, 'referrer_id');
    }

    protected static function booted()
    {
        static::creating(function ($member) {
            if (empty($member->referral_code)) {
                $member->referral_code = self::generateUniqueReferralCode();
            }
            if (empty($member->membership_id)) {
                $member->membership_id = $member->generateMembershipId();
            }
        });

        static::updated(function ($member) {
            if ($member->isDirty('referral_count')) {
                $member->updateStrategicRank();
            }
            
            // Generate membership ID if it was missing and now we have plan/role info
            if (empty($member->membership_id) && ($member->role_id || $member->membership_plan_id)) {
                $member->updateQuietly(['membership_id' => $member->generateMembershipId()]);
            }
        });
    }

    /**
     * Generate a unique, structured Membership ID.
     * Format: IBSA-[ROLE][PLAN]-[JOIN-MMYY][EXP-MMYY]-[RANDOM-4]
     */
    public function generateMembershipId()
    {
        $roleMap = [1 => 'MEM', 2 => 'CHM', 3 => 'BRD', 4 => 'ADV', 5 => 'ALH', 6 => 'STP', 7 => 'VCP', 8 => 'CTY', 9 => 'MNT', 10 => 'INV', 11 => 'STC'];
        $planMap = [
            'booster' => 'BST', 
            'corporate-booster' => 'CBST', 
            'corporate-prime' => 'CPRM', 
            'international' => 'INTL', 
            'lifetime' => 'LFTM'
        ];
        
        $roleCode = $roleMap[$this->role_id] ?? 'GEN';
        $planCode = $planMap[$this->membership_plan_id] ?? 'GST';
        
        $startDateStr = $this->membership_start ?? $this->created_at ?? date('Y-m-d');
        $joinDate = \Carbon\Carbon::parse($startDateStr)->format('my');
        
        $endDateStr = $this->membership_end ?? null;
        $expDate = $endDateStr ? \Carbon\Carbon::parse($endDateStr)->format('my') : '9999';
        
        $random = strtoupper(\Illuminate\Support\Str::random(4));
        
        return "IBSA-{$roleCode}{$planCode}-{$joinDate}{$expDate}-{$random}";
    }

    public function updateStrategicRank()
    {
        $count = $this->referral_count;
        $rank = 'Member';
        
        if ($count >= 50) $rank = 'Global Ambassador';
        elseif ($count >= 20) $rank = 'Strategic Partner';
        elseif ($count >= 10) $rank = 'Growth Leader';
        elseif ($count >= 5) $rank = 'Rising Star';

        if ($this->strategic_rank !== $rank) {
            $this->strategic_rank = $rank;
            $this->saveQuietly();
        }
    }

    private static function generateUniqueReferralCode()
    {
        do {
            // Updated to 8 characters total (IBS-XXXX) to fit existing DB columns
            $code = 'IBS-' . strtoupper(substr(md5(uniqid()), 0, 4));
        } while (self::where('referral_code', $code)->exists());
        return $code;
    }

    public function council()
    {
        return $this->belongsTo(Council::class);
    }

    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function bookings()
    {
        return $this->hasMany(EventBooking::class);
    }

    public function memberRole()
    {
        return $this->belongsTo(MemberRole::class, 'role_id');
    }

    /**
     * Get the total event passes allowed for this member's plan.
     */
    public function totalAllowedPasses()
    {
        return $this->membershipPlan?->event_passes_limit ?? 0;
    }

    /**
     * Get the number of membership passes already used by the member.
     */
    public function usedPassesCount()
    {
        return $this->bookings()
            ->where('is_pass_usage', true)
            ->where('status', 'Confirmed')
            ->count();
    }

    /**
     * Get the number of remaining membership passes.
     */
    public function remainingPassesCount()
    {
        return max(0, $this->totalAllowedPasses() - $this->usedPassesCount());
    }

    /**
     * Check if the member can use a pass for a specific ticket.
     */
    public function canUsePassOnTicket($ticket)
    {
        if (!$ticket->allow_membership_pass) {
            return [false, "This ticket type is not eligible for Membership Pass usage."];
        }

        if ($this->remainingPassesCount() <= 0) {
            return [false, "You have used all of your " . $this->totalAllowedPasses() . " annual membership passes."];
        }

        return [true, "Eligible to use membership pass."];
    }
}
