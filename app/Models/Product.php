<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected  $connection = 'mysql';
    use HasFactory;

    protected $casts = [
        'price' => 'float',
        'quantity' => 'int',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'price',
        'quantity',
        'description',
    ];
}
