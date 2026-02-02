<?php

use App\Http\Middleware\CheckFixturesEnabled;
use App\Livewire\About;
use App\Livewire\About\Competition;
use App\Livewire\About\Facilities;
use App\Livewire\About\History;
use App\Livewire\About\Location;
use App\Livewire\About\Membership;
use App\Livewire\About\Officers;
use App\Livewire\About\PlayLearn;
use App\Livewire\Contact;
use App\Livewire\EventShow;
use App\Livewire\EventsList;
use App\Livewire\FixtureShow;
use App\Livewire\FixturesInfo;
use App\Livewire\FixturesList;
use App\Livewire\Home;
use App\Livewire\NewsList;
use App\Livewire\NewsShow;
use App\Livewire\ResultsList;
use App\Livewire\SearchResults;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/about', About::class)->name('about');
Route::get('/about/location', Location::class)->name('about.location');
Route::get('/about/officers', Officers::class)->name('about.officers');
Route::get('/about/facilities', Facilities::class)->name('about.facilities');
Route::get('/about/play-learn', PlayLearn::class)->name('about.play-learn');
Route::get('/about/membership', Membership::class)->name('about.membership');
Route::get('/about/history', History::class)->name('about.history');
Route::get('/about/competition', Competition::class)->name('about.competition');
Route::middleware(['web'])->group(function () {
    Route::middleware([CheckFixturesEnabled::class])->group(function () {
        Route::get('/fixtures', FixturesList::class)->name('fixtures');
        Route::get('/fixtures/info', FixturesInfo::class)->name('fixtures.info');
        Route::get('/fixtures/{fixture}', FixtureShow::class)->name('fixtures.show');
        Route::get('/results', ResultsList::class)->name('results');
    });
});

Route::get('/news', NewsList::class)->name('news');
Route::get('/news/{newsArticle:slug}', NewsShow::class)->name('news.show');
Route::get('/events', EventsList::class)->name('events');
Route::get('/events/{event:slug}', EventShow::class)->name('events.show');
Route::get('/contact', Contact::class)->name('contact');

Route::get('/search', SearchResults::class)->name('search');
