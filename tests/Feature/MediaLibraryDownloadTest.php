<?php

namespace Tests\Feature;

use Filament\Facades\Filament;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibrary;
use Tests\TestCase;

class MediaLibraryDownloadTest extends TestCase
{
    public function test_media_library_file_information_allows_downloads(): void
    {
        $plugin = Filament::getPanel('admin')->getPlugin('ralphjsmit/laravel-filament-media-library');

        $this->assertInstanceOf(FilamentMediaLibrary::class, $plugin);
        $this->assertContains(
            'download',
            $plugin->getDriver()->getFileInfoActions()->map->getName()->all(),
        );
    }
}
