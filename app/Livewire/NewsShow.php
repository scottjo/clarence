<?php

namespace App\Livewire;

use App\Models\NewsArticle;
use Illuminate\View\View;
use Livewire\Component;

class NewsShow extends Component
{
    public NewsArticle $newsArticle;

    public function mount(NewsArticle $newsArticle): mixed
    {
        if (! $newsArticle->is_active || ($newsArticle->published_at && $newsArticle->published_at->isFuture())) {
            abort(404);
        }

        if ($newsArticle->is_members_only && ! auth()->check()) {
            return redirect()->route('members');
        }

        $this->newsArticle = $newsArticle;

        return null;
    }

    public function render(): View
    {
        return view('livewire.news-show')->layout('layouts.app', [
            'title' => $this->newsArticle->title,
            'metaDescription' => str(html_entity_decode(strip_tags($this->newsArticle->content), ENT_QUOTES, 'UTF-8'))->limit(160),
        ]);
    }
}
