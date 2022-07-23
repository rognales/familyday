<?php

namespace App\Notifications;

use App\Mail\RegistrationConfirmation;
use App\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegistrationIsConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $participant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Contracts\Mail\Mailable|\Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new RegistrationConfirmation($this->participant))->to($notifiable->email);

        return (new MailMessage)->greeting("Hello, {$this->participant->name}!")
            ->success()
            ->action('Upload Proof of Payment', route('registration_upload', $this->participant))
            ->markdown('vendor.notifications.email', [
                'participant' => $this->participant,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
