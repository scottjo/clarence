<?php

namespace App\Filament\Resources\MemberQuestionComments;

use App\Filament\Resources\MemberQuestionComments\Pages\CreateMemberQuestionComment;
use App\Filament\Resources\MemberQuestionComments\Pages\EditMemberQuestionComment;
use App\Filament\Resources\MemberQuestionComments\Pages\ListMemberQuestionComments;
use App\Filament\Resources\MemberQuestionComments\Schemas\MemberQuestionCommentForm;
use App\Filament\Resources\MemberQuestionComments\Tables\MemberQuestionCommentsTable;
use App\Models\MemberQuestionComment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MemberQuestionCommentResource extends Resource
{
    protected static ?string $model = MemberQuestionComment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleLeftRight;

    protected static string|UnitEnum|null $navigationGroup = 'Members';

    protected static ?string $navigationLabel = 'Q&A Comments';

    protected static ?string $modelLabel = 'Q&A comment';

    protected static ?string $pluralModelLabel = 'Q&A comments';

    protected static ?int $navigationSort = 103;

    public static function form(Schema $schema): Schema
    {
        return MemberQuestionCommentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MemberQuestionCommentsTable::configure($table);
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
            'index' => ListMemberQuestionComments::route('/'),
            'create' => CreateMemberQuestionComment::route('/create'),
            'edit' => EditMemberQuestionComment::route('/{record}/edit'),
        ];
    }
}
