<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryPackage extends Model
{
protected $fillable = [
    'vendor_id',
    'name',
    'description',
    'pricing_type',
    'price_per_unit',
    'estimated_hours',
    'is_active',
];
    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}