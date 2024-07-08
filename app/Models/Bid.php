<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\OutbidNotification;
use Illuminate\Support\Facades\Notification;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'amount', 'status'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($bid) {
            // Notify users who were outbid
            $previousHighestBid = $bid->product->bids()
                ->where('id', '!=', $bid->id)
                ->orderBy('amount', 'desc')
                ->first();

            if ($previousHighestBid) {
                Notification::send($previousHighestBid->user, new OutbidNotification($previousHighestBid->product));
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(NewProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
