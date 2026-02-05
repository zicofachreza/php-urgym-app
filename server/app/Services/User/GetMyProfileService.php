<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GetMyProfileService
{
    public function execute(): User
    {
        return Auth::user();
    }
}
