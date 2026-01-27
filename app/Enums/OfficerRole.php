<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OfficerRole: string implements HasLabel
{
    case President = 'President';
    case VicePresident = 'Vice President';
    case ClubSecretary = 'Club Secretary';
    case ClubTreasurer = 'Club Treasurer';
    case MembershipSecretary = 'Membership Secretary';
    case MatchSecretary = 'Match Secretary';
    case MensCaptain = "Men's Captain";
    case MensViceCaptain = "Men's Vice Captain";
    case LadiesCaptain = 'Ladies Captain';
    case LadiesViceCaptain = 'Ladies, Vice Captain';
    case AssistantTreasurer = 'Assistant Treasurer';
    case SafeguardingOfficer = 'Safeguarding Officer';
    case GreensManager = 'Greens Manager';
    case AssistantGreensManager = 'Assistant Greens Manager';
    case BarManager = 'Bar Manager';
    case AssistantBarManager = 'Assistant Bar Manager';
    case HouseManager = 'House Manager';
    case AssistantHouseManager = 'Assistant House Manager';
    case CountyLeagueRep = 'County League Rep';
    case CateringOfficer = 'Catering Officer';
    case Over55sLeagueRep = 'Over 55s League Rep';
    case ITOfficer = 'IT Officer';

    public function getLabel(): ?string
    {
        return $this->value;
    }
}
