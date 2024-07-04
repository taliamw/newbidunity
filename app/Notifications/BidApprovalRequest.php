<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\NewProduct;

class BidApprovalRequest extends Notification
{
    use Queueable;

    protected $user;
    protected $product;
    protected $amount;

    public function __construct(User $user, NewProduct $product, $amount)
    {
        $this->user = $user;
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
                    ->line("{$this->user->name} has requested to place a bid of \${$this->amount} on {$this->product->name}.")
                    ->action('Approve Bid', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
