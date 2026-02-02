<?php

namespace App\Filament\Resources\IntroBlocks;

use App\Filament\Resources\IntroBlocks\Pages\CreateIntroBlock;
use App\Filament\Resources\IntroBlocks\Pages\EditIntroBlock;
use App\Filament\Resources\IntroBlocks\Pages\ListIntroBlocks;
use App\Filament\Resources\IntroBlocks\Schemas\IntroBlockForm;
use App\Filament\Resources\IntroBlocks\Tables\IntroBlocksTable;
use App\Models\IntroBlock;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class IntroBlockResource extends Resource
{
    protected static ?string $model = IntroBlock::class;

    protected static BackedEnum|null|string $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static null|string|UnitEnum $navigationGroup = 'Configuration';

    public static function form(Schema $schema): Schema
    {
        return IntroBlockForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IntroBlocksTable::configure($table);
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
            'index' => ListIntroBlocks::route('/'),
            'create' => CreateIntroBlock::route('/create'),
            'edit' => EditIntroBlock::route('/{record}/edit'),
        ];
    }
}
