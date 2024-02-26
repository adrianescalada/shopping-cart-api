<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected  $connection = 'mysql';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'customer',
        'products',
        'total_amount',
        'payment',
        'shipping_address',
        'billing_address',
        'links',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'customer' => 'json',
        'products' => 'json',
        'payment' => 'json',
        'shipping_address' => 'json',
        'billing_address' => 'json',
        'links' => 'json',
    ];
}
