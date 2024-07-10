<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\NewProduct; // Adjust if your model namespace is different

class ListingRejected extends Notification
{
    use Queueable;

    protected $product;
    protected $reason;

    public function __construct(NewProduct $product, $reason)
    {
        $this->product = $product;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->line('Your listing "' . $this->product->name . '" has been rejected.')
                    ->line('Reason: '.$this->reason)
                    ->line('Thank you for using BidUnity!');
    }
}
