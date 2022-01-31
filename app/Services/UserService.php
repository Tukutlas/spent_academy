<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAccess;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserService
{
    public static function createUser(Request $request)
    {
        $token = Str::random(64);

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email_address = $request->email;
        $user->phone_number = $request->phone;
        $user->country_id = $request->country;
        $user->state_id = $request->state;
        $user->city_id = $request->city;
        $user->password = Hash::make($request->password);
        $user->login_token = $token;
        $user->status = "active";
        $user->user_type = $request->user_type;
        $user->save();

        
        if($request->user_type == 'student'){
            $user_access = new UserAccess;
            $user_access->user_id = $user->id;
            $section = Section::where('name', $request->user_type)->first();
            $user_access->section_id = $section->id;
            $user_access->save();
        }elseif ($request->user_type == 'instructor') {        
            $user_access = new UserAccess;
            $user_access->user_id = $user->id;
            $section = Section::where('name', $request->user_type)->first();
            $user_access->section_id = $section->id;
            $user_access->save();
        }

        
        
        return $user;
    }

    public static function validateUser($user)
    {
        $user = User::where('id', $user->id)->first();
        throw_if(
            !$user,
            new \InvalidArgumentException('User account doesn\'t exist.')
        );

        return $user;
    }

    public static function getUserAccess($user)
    {
        $user_accesses = UserAccess::with(['sections'])->where('user_id', $user->id)
            ->get();

        $access = [];
        foreach ($user_accesses as $user_access) { 
            $access[] = $user_access->sections;
         }
         return $access;
    }
}