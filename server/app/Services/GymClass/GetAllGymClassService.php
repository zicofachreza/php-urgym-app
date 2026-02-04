<?php

namespace App\Services\GymClass;

use App\Models\GymClass;
use Illuminate\Database\Eloquent\Collection;

class GetAllGymClassService
{
    public function execute(): Collection
    {
        return GymClass::query()->get();
    }
}
