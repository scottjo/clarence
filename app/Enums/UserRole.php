<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case SuperUser = 'super_user';
    case Administrator = 'administrator';
    case ContentMaintainer = 'content_maintainer';
    case MediaUser = 'media_user';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SuperUser => 'Super User',
            self::Administrator => 'Administrator',
            self::ContentMaintainer => 'Content Maintainer',
            self::MediaUser => 'Media User',
        };
    }
}
