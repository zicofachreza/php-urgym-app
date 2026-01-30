<?php

namespace App\Exceptions\GymClass;

use Exception;

class GymClassNotFoundException extends Exception
{
    public function __construct($message = 'Gym class not found.')
    {
        parent::__construct($message);
    }
}
