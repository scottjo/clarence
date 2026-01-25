<?php

namespace App\Models;

use App\Enums\FixtureType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Fixture extends Model
{
    /** @use HasFactory<\Database\Factories\FixtureFactory> */
    use HasFactory;

    protected $fillable = [
        'type',
        'opponent',
        'date',
        'venue',
        'competition',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
            'type' => FixtureType::class,
        ];
    }

    public function result(): HasOne
    {
        return $this->hasOne(Result::class);
    }
}
