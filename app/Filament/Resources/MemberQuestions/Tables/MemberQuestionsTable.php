<?php

namespace App\Filament\Resources\MemberQuestions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MemberQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(60),
                TextColumn::make('body')
                    ->label('Details')
                    ->searchable()
                    ->limit(80)
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Submitted by')
                    ->searchable(),
                IconColumn::make('is_anonymous')
                    ->label('Anonymous')
                    ->boolean(),
                TextColumn::make('display_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_locked')
                    ->label('Locked')
                    ->boolean(),
                IconColumn::make('allow_member_answers')
                    ->label('Open answers')
                    ->boolean(),
                TextColumn::make('answers_count')
                    ->label('Answers')
                    ->counts('answers')
                    ->sortable(),
                TextColumn::make('comments_count')
                    ->label('Comments')
                    ->counts('comments')
                    ->sortable(),
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
                TernaryFilter::make('is_locked')
                    ->label('Locked'),
                TernaryFilter::make('allow_member_answers')
                    ->label('Open answers'),
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
