<?php

namespace App\Services\User;

use App\Models\User;

class GetUserByIdService
{
    public function execute(User $user): User
    {
        $user->makeHidden(['password']);

        return $user;
    }
}
