<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category',
        'price',
        'description',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
