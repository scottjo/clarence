<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\NewsArticle;
use App\Models\Newsletter;
use App\Models\Setting;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

class MembersArea extends Component
{
    use WithPagination;

    public string $password = '';

    public bool $isAuthenticated = false;

    public function mount(): void
    {
        if (Session::get('members_authenticated')) {
            $this->isAuthenticated = true;
        }
    }

    public function login(): void
    {
        $settings = config('settings');

        if (! $settings instanceof Setting) {
            $settings = Setting::first();
        }

        $correctPassword = $settings?->members_password;

        if ($this->password && $this->password === $correctPassword) {
            $this->isAuthenticated = true;
            Session::put('members_authenticated', true);
        } else {
            $this->addError('password', 'Incorrect password.');
        }
    }

    public function logout(): void
    {
        $this->isAuthenticated = false;
        Session::forget('members_authenticated');
    }

    public function render()
    {
        if (! $this->isAuthenticated) {
            return view('livewire.members-area-login')
                ->layout('layouts.app', ['title' => 'Members Login']);
        }

        $newsArticles = NewsArticle::where('is_active', true)
            ->where('is_members_only', true)
            ->where('published_at', '<=', now())
            ->latest('published_at')
            ->paginate(6);

        $newsletters = Newsletter::where('is_active', true)
            ->latest('issue_date')
            ->get();

        $announcements = Announcement::forMembers()->latest()->get();

        return view('livewire.members-area', [
            'newsArticles' => $newsArticles,
            'newsletters' => $newsletters,
            'announcements' => $announcements,
        ])->layout('layouts.app', ['title' => 'Members Area']);
    }
}
