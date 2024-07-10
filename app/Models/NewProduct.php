<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class NewProduct extends Model
{
    use HasFactory;

    protected $table = 'new_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'auction_status',
        'duration',
        'duration_unit',
        'end_time',
        'status',
    ];


    public function bids()
    {
        return $this->hasMany(Bid::class, 'product_id');
    }
 
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'user_wishlists', 'new_product_id', 'user_id');
    }
    public function getImageAttribute($value)
    {
        return asset('storage/' . $value);
    }
   public function isAuctionActive()
    {
        $endDate = $this->created_at->addDays($this->duration);
        return Carbon::now()->lt($endDate);
    }

    public function getEndTime()
    {
        return $this->created_at->addDays($this->duration)->toDateTimeString();
    }

    public function listings()
{
    return $this->hasMany(NewProduct::class);
}
public function documents()
{
    return $this->hasMany(ProductDocument::class);
}


}

