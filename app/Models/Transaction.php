<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_id',
        'amount',
        'status',
        'transaction_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'items',
        'message',
    ];

    protected $casts = [
        'amount' => 'integer',
        'items' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
