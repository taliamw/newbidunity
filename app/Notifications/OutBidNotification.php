<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NewProduct;

class OutbidNotification extends Notification
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
                    ->line("You have been outbid on {$this->product->name}.")
                    ->action('View Product', url('/products/' . $this->product->id))
                    ->line('Increase your bid to stay in the lead!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
        ];
    }
}
