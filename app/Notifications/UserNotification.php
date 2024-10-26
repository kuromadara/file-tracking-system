<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {

        return ['database'];

        // return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {

        return [
            'message' => $this->message,
            'user_id' => $notifiable->id, // This will store the user ID
        ];
    }


    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Notification')
                    ->line($this->message)
                    ->action('View Notification', url('/notifications'))
                    ->line('Thank you for using our application!');
    }
}
