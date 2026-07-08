<?php

namespace App\Filament\Resources\MemberQuestions;

use App\Filament\Resources\MemberQuestions\Pages\CreateMemberQuestion;
use App\Filament\Resources\MemberQuestions\Pages\EditMemberQuestion;
use App\Filament\Resources\MemberQuestions\Pages\ListMemberQuestions;
use App\Filament\Resources\MemberQuestions\Schemas\MemberQuestionForm;
use App\Filament\Resources\MemberQuestions\Tables\MemberQuestionsTable;
use App\Models\MemberQuestion;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MemberQuestionResource extends Resource
{
    protected static ?string $model = MemberQuestion::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::QuestionMarkCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Members';

    protected static ?string $navigationLabel = 'Q&A Questions';

    protected static ?string $modelLabel = 'Q&A question';

    protected static ?string $pluralModelLabel = 'Q&A questions';

    protected static ?int $navigationSort = 101;

    public static function form(Schema $schema): Schema
    {
        return MemberQuestionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberQuestionsTable::configure($table);
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
            'index' => ListMemberQuestions::route('/'),
            'create' => CreateMemberQuestion::route('/create'),
            'edit' => EditMemberQuestion::route('/{record}/edit'),
        ];
    }
}
