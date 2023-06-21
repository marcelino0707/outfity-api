<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title_cart',
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function cart_detail()
    // {
    //     return $this->belongsTo(CartDetail::class);
    // }
}
