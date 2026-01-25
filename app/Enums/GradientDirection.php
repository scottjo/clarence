<?php

namespace App\Enums;

enum GradientDirection: string
{
    case LeftToRight = 'to right';
    case RightToLeft = 'to left';
    case TopToBottom = 'to bottom';
    case BottomToTop = 'to top';

    public function getLabel(): string
    {
        return match ($this) {
            self::LeftToRight => 'Left to Right',
            self::RightToLeft => 'Right to Left',
            self::TopToBottom => 'Top to Bottom',
            self::BottomToTop => 'Bottom to Top',
        };
    }
}
