<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    // public function carts()
    // {
    //     return $this->hasMany(Cart::class);
    // }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
