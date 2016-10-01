<?php

namespace ESCOJ\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ConfirmAccount extends Notification
{
    use Queueable;

     /**
     * The account confirmation code.
     *
     * @var string
     */
    public $confirmation_code;

    /**
     * Create a notification instance.
     *
     * @param  string  $confirmation_code
     * @return void
     */
    public function __construct($confirmation_code)
    {
        $this->confirmation_code = $confirmation_code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

      /**
     * Build the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->greeting('What´s up!')
            ->line('You are receiving this email because you have registered in the system but need to verify your account.')
            ->action('Verify Account', url('register/verify', $this->confirmation_code))
            ->line('If you did not register you can contact us.');
    }
}
