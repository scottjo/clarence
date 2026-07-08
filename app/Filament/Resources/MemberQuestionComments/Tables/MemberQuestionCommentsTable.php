<?php

namespace App\Filament\Resources\MemberQuestionComments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MemberQuestionCommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('answer.question.title')
                    ->label('Question')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('answer.body')
                    ->label('Answer')
                    ->searchable()
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('body')
                    ->label('Comment')
                    ->searchable()
                    ->limit(90),
                TextColumn::make('user.name')
                    ->label('Comment by')
                    ->searchable(),
                IconColumn::make('is_anonymous')
                    ->label('Anonymous')
                    ->boolean(),
                TextColumn::make('display_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_anonymous')
                    ->label('Anonymous'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
