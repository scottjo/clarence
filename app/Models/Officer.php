<?php

namespace App\Models;

use App\Enums\OfficerRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'avatar',
        'sort_order',
        'is_active',
        'classification_id',
    ];

    protected function casts(): array
    {
        return [
            'role' => OfficerRole::class,
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function classification(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OfficerClassification::class, 'classification_id');
    }
}
