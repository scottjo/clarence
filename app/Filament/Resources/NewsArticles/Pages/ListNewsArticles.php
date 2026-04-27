<?php

namespace App\Filament\Resources\NewsArticles\Pages;

use App\Filament\Resources\NewsArticles\NewsArticleResource;
use App\Models\NewsArticle;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Artisan;

class ListNewsArticles extends ListRecords
{
    protected static string $resource = NewsArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('regenerateThumbnails')
                ->label('Regenerate Thumbnails')
                ->color('info')
                ->requiresConfirmation()
                ->action(function () {
                    $articles = NewsArticle::all();
                    $mediaCount = 0;

                    foreach ($articles as $article) {
                        foreach ($article->media as $media) {
                            Artisan::call('media-library:regenerate', [
                                '--ids' => [$media->id],
                                '--no-interaction' => true,
                            ]);
                            $mediaCount++;
                        }
                    }

                    Notification::make()
                        ->title('Thumbnails regenerated')
                        ->body("Successfully regenerated thumbnails for {$mediaCount} media items.")
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
