<?php

namespace App\Jobs;

use App\Models\NewProduct;
use App\Notifications\AuctionWonNotification;

class DetermineAuctionWinners extends Job
{
    public function handle()
    {
        $products = NewProduct::where('auction_status', 'active')
            ->where('end_time', '<', now())
            ->get();

        foreach ($products as $product) {
            $highestBid = $product->bids()->orderBy('amount', 'desc')->first();
            $product->winner_id = $highestBid ? $highestBid->user_id : null;
            $product->auction_status = 'ended';
            $product->save();

            if ($highestBid) {
                $highestBid->user->notify(new AuctionWonNotification($product));
            }
}
}
}