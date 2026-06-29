<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'vendor_id',
        'rider_id',
        'laundry_package_id',
        'service_type',
        'weight_quantity',
        'total_price',
        'collection_address',
        'scheduled_pickup_at',
        'status',
        'estimated_turnaround',
        'completed_at'
    ];

    protected $casts = [
        'scheduled_pickup_at' => 'datetime',
        'completed_at' => 'datetime',
        'weight_quantity' => 'float',
        'total_price' => 'float',
    ];

    // ==========================================
    // STATUS CONSTANTS
    // ==========================================
    const STATUS_PENDING = 'PENDING';
    const STATUS_ACCEPTED = 'ACCEPTED';
    const STATUS_PICKED_UP = 'PICKED_UP';
    const STATUS_WASHING = 'WASHING';
    const STATUS_READY = 'READY';
    const STATUS_EN_ROUTE = 'EN_ROUTE';
    const STATUS_DELIVERED = 'DELIVERED';
    const STATUS_REJECTED = 'REJECTED';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_PENDING_ASSIGNMENT = 'PENDING_ASSIGNMENT';

    // ==========================================
    // STATUS TRANSITION RULES
    // ==========================================
    public static function getAllowedTransitions(): array
    {
        return [
            self::STATUS_PENDING => [self::STATUS_ACCEPTED, self::STATUS_CANCELLED],
            self::STATUS_ACCEPTED => [self::STATUS_PICKED_UP, self::STATUS_REJECTED],
            self::STATUS_PICKED_UP => [self::STATUS_WASHING],
            self::STATUS_WASHING => [self::STATUS_READY],
            self::STATUS_READY => [self::STATUS_EN_ROUTE, self::STATUS_DELIVERED],
            self::STATUS_EN_ROUTE => [self::STATUS_DELIVERED],
            self::STATUS_DELIVERED => [],
            self::STATUS_REJECTED => [],
            self::STATUS_CANCELLED => [],
            self::STATUS_PENDING_ASSIGNMENT => [self::STATUS_ACCEPTED, self::STATUS_REJECTED],
        ];
    }

    public function canTransitionTo(string $newStatus): bool
    {
        $allowed = self::getAllowedTransitions()[$this->status] ?? [];
        return in_array($newStatus, $allowed);
    }

    public function transitionTo(string $newStatus): bool
    {
        if (!$this->canTransitionTo($newStatus)) {
            return false;
        }

        $oldStatus = $this->status;
        $this->status = $newStatus;
        $this->save();

        // Log the status change
        OrderStatusLog::create([
            'order_id' => $this->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_by' => auth()->id(),
        ]);

        if ($newStatus === self::STATUS_DELIVERED) {
            $this->completed_at = now();
            $this->save();
        }

        return true;
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function rider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rider_id');
    }

    public function laundryPackage(): BelongsTo
    {
        return $this->belongsTo(LaundryPackage::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class);
    }

    // ==========================================
    // SCOPES
    // ==========================================
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', [
            self::STATUS_PENDING,
            self::STATUS_ACCEPTED,
            self::STATUS_PICKED_UP,
            self::STATUS_WASHING,
            self::STATUS_READY,
            self::STATUS_EN_ROUTE,
            self::STATUS_PENDING_ASSIGNMENT
        ]);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_DELIVERED);
    }

    public function scopeByVendor($query, $vendorId)
    {
        return $query->where('vendor_id', $vendorId);
    }

    public function scopeByCustomer($query, $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeByRider($query, $riderId)
    {
        return $query->where('rider_id', $riderId);
    }
}