<?php

namespace App\Filament\Resources\PinnedItems;

use App\Filament\Resources\PinnedItems\Pages\CreatePinnedItem;
use App\Filament\Resources\PinnedItems\Pages\EditPinnedItem;
use App\Filament\Resources\PinnedItems\Pages\ListPinnedItems;
use App\Filament\Resources\PinnedItems\Schemas\PinnedItemForm;
use App\Filament\Resources\PinnedItems\Tables\PinnedItemsTable;
use App\Models\PinnedItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PinnedItemResource extends Resource
{
    protected static ?string $model = PinnedItem::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedTag;

    protected static null|string|\UnitEnum $navigationGroup = 'Content';

    protected static ?int $navigationSort = 301;

    public static function form(Schema $schema): Schema
    {
        return PinnedItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PinnedItemsTable::configure($table);
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
            'index' => ListPinnedItems::route('/'),
            'create' => CreatePinnedItem::route('/create'),
            'edit' => EditPinnedItem::route('/{record}/edit'),
        ];
    }
}
