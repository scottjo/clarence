<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficerClassification extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerClassificationFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'bg_color',
        'text_color',
        'bg_color_dark',
        'text_color_dark',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function officers(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Officer::class, 'classification_id');
    }
}
