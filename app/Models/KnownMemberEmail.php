<?php

namespace App\Models;

use Database\Factories\KnownMemberEmailFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnownMemberEmail extends Model
{
    /** @use HasFactory<KnownMemberEmailFactory> */
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
    ];

    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value): string => strtolower(trim($value)),
        );
    }

    public static function recognises(string $email): bool
    {
        return self::query()
            ->where('email', strtolower(trim($email)))
            ->exists();
    }
}
