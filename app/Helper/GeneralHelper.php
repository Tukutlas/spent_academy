<?php

namespace App\Helper;
// use Log;
use App\Models\User;
// use App\Models\Cities;
// use App\Models\States;


class GeneralHelper
{
    public static function validateToken($request) {

        if(!isset($request->header()['authorization'])) return false;

        $token = explode(" ",$request->header()['authorization'][0]);

        // $user = Admin::findByAuthToken($token[1]);
        $user = User::findByAuthToken($token[1]);
        if($user){
            return true;
        } 

        return false;
    }
    
    public static function getActiveUser($request) {
        $token = explode(" ",$request->header()['authorization'][0]);
        return User::findByAuthToken($token[1]);
    }
    
}
