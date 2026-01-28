<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'phone',
        'website',
        'show_on_all_pages',
        'pages',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'show_on_all_pages' => 'boolean',
            'pages' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
