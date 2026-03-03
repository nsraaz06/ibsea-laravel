<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRole extends Model
{
    use HasFactory;

    protected $fillable = ['role_name', 'hierarchy_level', 'show_in_leadership', 'card_display_pattern'];
}
