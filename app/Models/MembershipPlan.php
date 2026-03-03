<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'title', 'tagline', 'fee_numeric', 'event_passes_limit', 'currency', 'currency_symbol', 'validity_days', 
        'benefits_json', 'highlights_json', 'detailed_benefits_json', 
        'premium_features_json', 'stats_json', 'theme',
        'id_card_template_id', 'certificate_template_id'
    ];

    protected $casts = [
        'benefits_json' => 'array',
        'highlights_json' => 'array',
        'detailed_benefits_json' => 'array',
        'premium_features_json' => 'array',
        'stats_json' => 'array',
    ];

    public function members()
    {
        return $this->hasMany(Member::class, 'membership_plan_id');
    }
}
