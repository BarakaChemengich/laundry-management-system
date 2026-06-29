<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    protected $fillable = [
        'order_id',
        'customer_id',
        'vendor_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    // ==========================================
    // HELPERS
    // ==========================================
    public static function getAverageRating($vendorId): float
    {
        return self::where('vendor_id', $vendorId)
            ->avg('rating') ?? 0.0;
    }

    public static function getRatingCount($vendorId): int
    {
        return self::where('vendor_id', $vendorId)->count();
    }
}