<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category',
        'color',
        'material',
        'img',
        'description',
        'dimensions',
        'stock',
        'rating',
        'customizable',
        'base_price',
    ];

    protected $casts = [
        'price' => 'integer',
        'stock' => 'integer',
        'rating' => 'float',
        'customizable' => 'boolean',
        'base_price' => 'integer',
    ];
}
