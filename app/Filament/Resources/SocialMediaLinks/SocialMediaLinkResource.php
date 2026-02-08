<?php

namespace App\Filament\Resources\SocialMediaLinks;

use App\Filament\Resources\SocialMediaLinks\Pages\CreateSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Pages\EditSocialMediaLink;
use App\Filament\Resources\SocialMediaLinks\Pages\ListSocialMediaLinks;
use App\Filament\Resources\SocialMediaLinks\Schemas\SocialMediaLinkForm;
use App\Filament\Resources\SocialMediaLinks\Tables\SocialMediaLinksTable;
use App\Models\SocialMediaLink;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SocialMediaLinkResource extends Resource
{
    protected static ?string $model = SocialMediaLink::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static null|string|UnitEnum $navigationGroup = 'Configuration';

    protected static ?int $navigationSort = 409;

    public static function form(Schema $schema): Schema
    {
        return SocialMediaLinkForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SocialMediaLinksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSocialMediaLinks::route('/'),
            'create' => CreateSocialMediaLink::route('/create'),
            'edit' => EditSocialMediaLink::route('/{record}/edit'),
        ];
    }
}
