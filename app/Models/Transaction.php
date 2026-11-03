<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_address',
        'phone',
        'payment_proof',
        'status',
        'payment_order_id',
        'payment_status',
        'payment_type',
        'payment_expires_at',
        'payment_token',
    ];

    protected $casts = [
        'payment_expires_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function details() {
        return $this->hasMany(TransactionDetail::class);
    }
}
