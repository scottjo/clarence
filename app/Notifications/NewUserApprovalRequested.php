<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserApprovalRequested extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $adminPath = trim((string) config('filament.admin_path', 'admin'), '/');

        return (new MailMessage)
            ->subject('New member registration needs approval')
            ->greeting('New member registration')
            ->line($this->user->name.' has registered for the members area.')
            ->line('Email: '.$this->user->email)
            ->line('Please review and approve this user in the admin area.')
            ->action('Review user', url($adminPath.'/users/'.$this->user->getKey().'/edit'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
