<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Session extends Model
{
    use HasFactory, HasUuids, Notifiable;

    /**
     * Primary key is UUID (non-incrementing)
     */
    protected $keyType = 'string';

    public $incrementing = false;

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'hashed_token',
        'device_info',
        'ip_address',
        'last_used_at',
        'expires_at',
        'user_id',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
