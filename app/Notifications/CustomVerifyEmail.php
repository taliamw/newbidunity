<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomVerifyEmail extends VerifyEmailNotification
{
    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
                    ->subject(Lang::get('Verify Email Address'))
                    ->greeting('Hello!')
                    ->line('Please click the button below to verify your email address.')
                    ->action(Lang::get('Verify Email Address'), $verificationUrl)
                    ->line('If you did not create an account, no further action is required.')
                    ->salutation('Regards, BidUnity')
                    ->line('© 2024 BidUnity. All rights reserved.');
    }
}