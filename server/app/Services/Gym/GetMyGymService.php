<?php

namespace App\Services\Gym;

use App\Models\Gym;
use Illuminate\Support\Facades\Auth;

class GetMyGymService
{
    public function execute()
    {
        $user = Auth::user();

        return Gym::with('news')
            ->where('user_id', $user->id)
            ->latest()
            ->get();
    }
}
