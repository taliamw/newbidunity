<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NewProduct;

class AuctionWonNotification extends Notification
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
                    ->line("Congratulations! You won the auction for {$this->product->name}.")
                    ->action('View Product', url('/products/' . $this->product->id))
                    ->line('Thank you for participating!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
        ];
    }
}
