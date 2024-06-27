<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withTimestamps()
                    ->as('membership');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
