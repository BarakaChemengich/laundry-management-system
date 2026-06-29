<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'merchant_request_id',
        'checkout_request_id',
        'amount',
        'amount_paid',
        'mpesa_receipt_number',
        'phone_number',
        'status',
        'payment_method'
    ];

    protected $casts = [
        'amount' => 'float',
        'amount_paid' => 'float',
    ];

    // ==========================================
    // STATUS CONSTANTS
    // ==========================================
    const STATUS_PENDING = 'PENDING';
    const STATUS_COMPLETED = 'COMPLETED';
    const STATUS_FAILED = 'FAILED';
    const STATUS_REFUNDED = 'REFUNDED';

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // ==========================================
    // HELPERS
    // ==========================================
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function markAsCompleted(string $receiptNumber, float $amountPaid): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'mpesa_receipt_number' => $receiptNumber,
            'amount_paid' => $amountPaid,
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => self::STATUS_FAILED]);
    }

    public function markAsRefunded(): void
    {
        $this->update(['status' => self::STATUS_REFUNDED]);
    }
}