<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\KnownMemberEmail;
use App\Models\NewsArticle;
use App\Models\Newsletter;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\NewUserApprovalRequested;
use App\Notifications\RegistrationAwaitingApproval;
use App\Notifications\UserApprovedNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithPagination;

class MembersArea extends Component
{
    use WithPagination;

    public string $formMode = 'login';

    public string $loginIdentifier = '';

    public string $loginPassword = '';

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public bool $isAuthenticated = false;

    public string $activeMembersTab = 'news';

    public bool $registrationSubmitted = false;

    public bool $registrationApproved = false;

    public function mount(): void
    {
        $this->isAuthenticated = Auth::check();
    }

    public function showLogin(): void
    {
        $this->formMode = 'login';
        $this->resetValidation();
    }

    public function showRegister(): void
    {
        $this->formMode = 'register';
        $this->registrationSubmitted = false;
        $this->registrationApproved = false;
        $this->resetValidation();
    }

    public function login(): void
    {
        $this->validate([
            'loginIdentifier' => ['required', 'string'],
            'loginPassword' => ['required', 'string'],
        ]);

        $login = trim($this->loginIdentifier);

        $user = User::query()
            ->whereRaw('lower(email) = ?', [strtolower($login)])
            ->orWhere('name', $login)
            ->get()
            ->first(fn (User $user): bool => Hash::check($this->loginPassword, $user->password));

        if ($user instanceof User && $user->isApproved()) {
            Auth::login($user);
            if (request()->hasSession()) {
                request()->session()->regenerate();
            }

            $this->isAuthenticated = true;
            $this->reset('loginIdentifier', 'loginPassword');
        } elseif ($user instanceof User) {
            $this->addError('loginIdentifier', 'Your registration is awaiting approval. We will email you once your account has been approved.');
        } else {
            $this->addError('loginIdentifier', 'These credentials do not match our records.');
        }
    }

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'same:passwordConfirmation'],
        ]);

        $email = strtolower($validated['email']);
        $isKnownMember = KnownMemberEmail::recognises($email);

        $user = User::query()->create([
            'name' => trim($validated['name']),
            'email' => $email,
            'password' => $validated['password'],
            'approved_at' => $isKnownMember ? now() : null,
        ]);

        if ($isKnownMember) {
            $user->notify(new UserApprovedNotification);
        } else {
            $user->notify(new RegistrationAwaitingApproval);

            User::superUserEmails()
                ->each(fn (string $email) => Notification::route('mail', $email)->notify(new NewUserApprovalRequested($user)));
        }

        $this->registrationSubmitted = true;
        $this->registrationApproved = $isKnownMember;
        $this->formMode = 'login';
        $this->reset('name', 'email', 'password', 'passwordConfirmation');
    }

    public function logout(): void
    {
        Auth::logout();
        if (request()->hasSession()) {
            request()->session()->invalidate();
            request()->session()->regenerateToken();
        }

        $this->isAuthenticated = false;
        $this->showLogin();
    }

    public function showNewsAndNewsletters(): void
    {
        $this->activeMembersTab = 'news';
    }

    public function showQuestionsAndAnswers(): void
    {
        $this->activeMembersTab = 'questions';
    }

    public function render(): mixed
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
        $settings = config('settings');

        if (! $settings instanceof Setting) {
            $settings = Setting::query()->first();
        }

        return view('livewire.members-area', [
            'newsArticles' => $newsArticles,
            'newsletters' => $newsletters,
            'announcements' => $announcements,
            'settings' => $settings,
        ])->layout('layouts.app', ['title' => 'Members Area']);
    }
}
