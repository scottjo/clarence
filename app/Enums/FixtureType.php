<?php

namespace App\Enums;

enum FixtureType: string
{
    case Men = 'Clarence Men';
    case Women = 'Clarence Women';
    case Competitions = 'Competitions';
    case CountyLeague = 'County League';
    case Over55sLeague = 'Over 55s League';
    case LadiesLeague = 'Ladies League';
    case Friendly = 'Friendly';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
