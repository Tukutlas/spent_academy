<?php

namespace App\Services;

use App\Models\User;
use App\Models\InstructorProfile;
use Illuminate\Http\Request;


class InstructorService
{
    
    public static function upgradeUserToInstructor(Request $request, $user)
    {
        $user_upgrade = UserService::validateUser($user);
        $user_upgrade->user_type = 2;
        $user_upgrade->save();
        
        return response()->json([
            'status' => true,
            'data' => $user_upgrade
        ]);
    }

    public static function getInstructorProfile($user)
    {
        $profile = InstructorProfile::where('instructor_id', $user->id)->get();
        return $profile;
    }
}