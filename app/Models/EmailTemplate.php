<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = ['name', 'subject', 'body'];

    public function campaigns()
    {
        return $this->hasMany(EmailCampaign::class, 'template_id');
    }
}
