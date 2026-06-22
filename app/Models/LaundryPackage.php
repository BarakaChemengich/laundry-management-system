<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaundryPackage extends Model
{
    protected $fillable = ['vendor_id', 'item_name', 'pricing_type', 'price_per_unit', 'estimated_hours'];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }
}