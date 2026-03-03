<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'form_id',
        'member_id',
        'data',
        'ip_address'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
