<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id',
        'stripe_payment_intent_id',
        'amount',
        'status',
    ];

    // Define any relationships or additional methods as needed

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
