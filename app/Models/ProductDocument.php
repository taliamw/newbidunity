<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'new_product_id',
        'path',
    ];

    public function product()
    {
        return $this->belongsTo(NewProduct::class, 'new_product_id');
    }
}
