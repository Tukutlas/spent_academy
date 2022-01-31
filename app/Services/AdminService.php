<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;


class AdminService
{
    public static function upgradeUserToInstructor($request, $user)
    {
        $user_upgrade = new User;
        $user_upgrade->role = 2;
        $user_upgrade->save();
        
    }
}