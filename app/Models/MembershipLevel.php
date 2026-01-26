<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipLevel extends Model
{
    /** @use HasFactory<\Database\Factories\MembershipLevelFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'benefits',
        'sort_order',
    ];
}
