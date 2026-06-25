<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['order_id', 'merchant_request_id', 'checkout_request_id', 'amount_paid', 'mpesa_receipt', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}