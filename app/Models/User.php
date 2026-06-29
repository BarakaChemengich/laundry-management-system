<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'role_id', 'name', 'email', 'phone_number', 'password', 'address', 'is_available', 'status'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    // ==========================================
    // ROLE RELATIONSHIPS
    // ==========================================
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ==========================================
    // ROLE CHECK HELPER METHODS
    // ==========================================
    public function isCustomer(): bool
    {
        return $this->role_id === 2;
    }

    public function isMamaFua(): bool
    {
        return $this->role_id === 3;
    }

    public function isVendor(): bool
    {
        return $this->role_id === 3;
    }

    public function isRider(): bool
    {
        return $this->role_id === 4;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 1;
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    public function laundryPackages()
    {
        return $this->hasMany(LaundryPackage::class, 'vendor_id');
    }

    public function ordersAsCustomer()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function ordersAsVendor()
    {
        return $this->hasMany(Order::class, 'vendor_id');
    }

    public function ordersAsRider()
    {
        return $this->hasMany(Order::class, 'rider_id');
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'customer_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'vendor_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
}