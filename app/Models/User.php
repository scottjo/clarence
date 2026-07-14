<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass-assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'approved_at',
        'is_admin',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'approved_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'roles' => 'array',
        ];
    }

    public function hasRole(UserRole $role): bool
    {
        return in_array($role->value, $this->roles ?? []);
    }

    public function isSuperUser(): bool
    {
        return $this->hasRole(UserRole::SuperUser) || self::superUserEmails()->contains(strtolower($this->email));
    }

    /**
     * @return Collection<int, string>
     */
    public static function superUserEmails(): Collection
    {
        return collect(explode(',', (string) config('app.super_user_email')))
            ->map(fn (string $email): string => strtolower(trim($email)))
            ->filter()
            ->values();
    }

    public function isApproved(): bool
    {
        return filled($this->approved_at) || $this->isSuperUser();
    }

    public function approve(): void
    {
        if ($this->isApproved()) {
            return;
        }

        $this->forceFill([
            'approved_at' => now(),
        ])->save();
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole(UserRole::Administrator) || $this->isSuperUser();
    }

    public function isContentMaintainer(): bool
    {
        return $this->hasRole(UserRole::ContentMaintainer) || $this->isAdministrator();
    }

    public function isMediaUser(): bool
    {
        return $this->hasRole(UserRole::MediaUser) || $this->isSuperUser();
    }

    public function canAnswerMemberQuestions(): bool
    {
        return $this->hasRole(UserRole::QuestionAnswerer) || $this->isAdministrator();
    }

    public function canModerateMemberQuestions(): bool
    {
        return $this->hasRole(UserRole::QuestionModerator) || $this->isSuperUser();
    }

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin || ! empty($this->roles) || $this->isSuperUser();
    }
}
