<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewProduct extends Model
{
    use HasFactory;

    protected $table = 'new_products';

    protected $fillable = ['name', 'description', 'price', 'image', 'auction_status'];

    public function bids()
    {
        return $this->hasMany(Bid::class, 'product_id');
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'user_wishlists', 'new_product_id', 'user_id');
    }
    public function getImageAttribute()
    {
        // Assuming image is stored as base64 in the database
        return base64_encode($this->attributes['image']); // Adjust based on your actual attribute name
    }
}
