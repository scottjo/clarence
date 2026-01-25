<?php

namespace App\Livewire;

use App\Models\NewsArticle;
use Livewire\Component;
use Livewire\WithPagination;

class NewsList extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.news-list', [
            'articles' => NewsArticle::where('is_active', true)
                ->where('published_at', '<=', now())
                ->latest('published_at')
                ->paginate(9),
        ])->layout('layouts.app');
    }
}
