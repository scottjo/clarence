<?php

namespace App\Models;

use Database\Factories\UsefulContactFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulContact extends Model
{
    /** @use HasFactory<UsefulContactFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'telephone',
        'email',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
