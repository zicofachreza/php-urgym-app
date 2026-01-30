<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GymClass extends Model
{
    use HasFactory, HasUuids, Notifiable;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'instructor',
        'schedule',
        'capacity',
        'duration',
        'description',
    ];

    protected $casts = [
        'schedule' => 'datetime',
        'capacity' => 'integer',
        'duration' => 'integer',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'bookings');
    }

    public function confirmedBookings()
    {
        return $this->bookings()
            ->where('status', BookingStatus::CONFIRMED);
    }

    public function getAvailableSlotsAttribute()
    {
        return $this->capacity - $this->confirmedBookings()->count();
    }
}
