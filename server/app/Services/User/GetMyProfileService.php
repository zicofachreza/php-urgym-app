<?php

namespace App\Services\User;

class GetMyProfileService
{
    public function execute()
    {
        $user = auth('api')->user();

        if (! $user) {
            abort(401, 'Unauthenticated');
        }

        return $user;
    }
}
