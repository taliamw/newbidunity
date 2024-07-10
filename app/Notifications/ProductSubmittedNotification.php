<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\NewProduct;

class ProductSubmittedNotification extends Notification
{
    use Queueable;

    protected $product;

    public function __construct(NewProduct $product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Your product has been submitted for review.')
                    ->action('View Product', url('/products/' . $this->product->id))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'message' => 'Your product has been submitted for review.'
        ];
    }
}
