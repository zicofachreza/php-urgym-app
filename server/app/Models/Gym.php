<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gym extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'phone_number',
        'latitude',
        'longitude',
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
