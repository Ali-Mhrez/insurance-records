<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwedInitialGuarantees extends Notification
{

    // you may implement this interface to speed up the app
    // but there is a prerequisite before implementing it
    // implements ShouldQueue
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($guarantee)
    {
        $this->guarantee = $guarantee;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->guarantee->id,
            'bidder_name' => $this->guarantee->bidder_name,
            'number' => $this->guarantee->number
        ];
    }
}
