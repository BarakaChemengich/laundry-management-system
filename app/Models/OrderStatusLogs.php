<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderStatusLogs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'status',
        'changed_by',
        'notes',
    ];

    /**
     * Establish relation mapping back to parent structural transaction.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Establish relation mapping to the identity entity who executed the action.
     */
    public function modifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}