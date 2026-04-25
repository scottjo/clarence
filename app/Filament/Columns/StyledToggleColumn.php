<?php

namespace App\Filament\Columns;

use Filament\Tables\Columns\ToggleColumn;

class StyledToggleColumn extends ToggleColumn
{
    public static function create(string $name, bool $inline = true): static
    {
        return static::make($name)
            ->inline($inline)
            ->onIcon('heroicon-o-check')
            ->offIcon('heroicon-o-x-mark')
            ->onColor('success')
            ->offColor('danger');
    }
}
