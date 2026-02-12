<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, HasUuids, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'gym_id',
        'username',
        'email',
        'password',
        'role',
        'is_member',
        'membership_expires_at',
        'reset_token',
        'reset_token_expires',
        'membership_barcode_token',
    ];

    /**
     * Hidden attributes for serialization
     */
    protected $hidden = [
        'password',
        'reset_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'is_member' => 'boolean',
        'membership_expires_at' => 'datetime',
        'reset_token_expires' => 'datetime',
        'password' => 'hashed',
    ];

    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function gymClasses()
    {
        return $this->belongsToMany(GymClass::class, 'bookings');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
