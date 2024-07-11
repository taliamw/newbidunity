<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\CustomVerifyEmail;
use Laravel\Jetstream\HasTeams;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasTeams;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'card_brand',
        'card_last4',
        'stripe_customer_id',
        'stripe_payment_method_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
                    ->withTimestamps()
                    ->as('membership');
    }

    public function currentTeam()
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function wishlist()
    {
        return $this->belongsToMany(NewProduct::class, 'user_wishlists', 'user_id', 'new_product_id');
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function listings()
{
    return $this->hasMany(NewProduct::class);
}

public function bids()
    {
        return $this->hasMany(Bid::class);
    }

}
