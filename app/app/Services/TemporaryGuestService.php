<?php

namespace App\Services;

use App\User;

class TemporaryGuestService
{
    public function get(): User
    {
        return User::first();
    }
}
