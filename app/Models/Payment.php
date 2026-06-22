<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'merchant_request_id', 'checkout_request_id', 'mpesa_receipt_number', 'amount', 'payment_status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}