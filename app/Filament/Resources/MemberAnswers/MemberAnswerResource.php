<?php

namespace App\Filament\Resources\MemberAnswers;

use App\Filament\Resources\MemberAnswers\Pages\CreateMemberAnswer;
use App\Filament\Resources\MemberAnswers\Pages\EditMemberAnswer;
use App\Filament\Resources\MemberAnswers\Pages\ListMemberAnswers;
use App\Filament\Resources\MemberAnswers\Schemas\MemberAnswerForm;
use App\Filament\Resources\MemberAnswers\Tables\MemberAnswersTable;
use App\Models\MemberAnswer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MemberAnswerResource extends Resource
{
    protected static ?string $model = MemberAnswer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleBottomCenterText;

    protected static string|UnitEnum|null $navigationGroup = 'Members';

    protected static ?string $navigationLabel = 'Q&A Answers';

    protected static ?string $modelLabel = 'Q&A answer';

    protected static ?string $pluralModelLabel = 'Q&A answers';

    protected static ?int $navigationSort = 102;

    public static function form(Schema $schema): Schema
    {
        return MemberAnswerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberAnswersTable::configure($table);
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
            'index' => ListMemberAnswers::route('/'),
            'create' => CreateMemberAnswer::route('/create'),
            'edit' => EditMemberAnswer::route('/{record}/edit'),
        ];
    }
}
