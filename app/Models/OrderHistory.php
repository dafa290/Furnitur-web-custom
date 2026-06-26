<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    use HasFactory;

    protected $table = 'order_histories';

    protected $fillable = [
        'user_id',
        'order_id',
        'total_amount',
        'status',
        'estimated_arrival',
        'order_date',
        'items',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'estimated_arrival' => 'datetime',
        'order_date' => 'datetime',
        'items' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
