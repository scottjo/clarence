<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Home::class)->name('home');
Route::get('/about', \App\Livewire\About::class)->name('about');
Route::get('/about/location', \App\Livewire\About\Location::class)->name('about.location');
Route::get('/about/officers', \App\Livewire\About\Officers::class)->name('about.officers');
Route::get('/about/facilities', \App\Livewire\About\Facilities::class)->name('about.facilities');
Route::get('/about/play-learn', \App\Livewire\About\PlayLearn::class)->name('about.play-learn');
Route::get('/about/membership', \App\Livewire\About\Membership::class)->name('about.membership');
Route::get('/about/history', \App\Livewire\About\History::class)->name('about.history');
Route::get('/about/competition', \App\Livewire\About\Competition::class)->name('about.competition');
Route::get('/fixtures', \App\Livewire\FixturesList::class)->name('fixtures');
Route::get('/fixtures/info', \App\Livewire\FixturesInfo::class)->name('fixtures.info');
Route::get('/fixtures/{fixture}', \App\Livewire\FixtureShow::class)->name('fixtures.show');
Route::get('/results', \App\Livewire\ResultsList::class)->name('results');
Route::get('/news', \App\Livewire\NewsList::class)->name('news');
Route::get('/news/{newsArticle:slug}', \App\Livewire\NewsShow::class)->name('news.show');
Route::get('/events', \App\Livewire\EventsList::class)->name('events');
Route::get('/events/{event:slug}', \App\Livewire\EventShow::class)->name('events.show');
Route::get('/contact', \App\Livewire\Contact::class)->name('contact');
