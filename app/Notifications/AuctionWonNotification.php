<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\NewProduct;
use Illuminate\Support\Facades\Auth;



class AuctionWonNotification extends Notification
{
    use Queueable;

    protected $product;
    protected $amount;

    public function __construct($product, $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Congratulations! You Won the Auction')
            ->line('Congratulations! You have won the auction for ' . $this->product->name)
            ->line('Winning Bid Amount: $' . $this->amount)
            ->action('Proceed to payment', route('teams.show', Auth::user()->currentTeam->id))
            ->line('Thank you for participating in the auction!');
    }
}
