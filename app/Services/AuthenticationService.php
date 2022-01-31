<?php


namespace App\Services;

// use App\Helper\Log;
use App\Helper\GeneralHelper;
use App\Models\User;
// use App\Models\Admin;
use App\Services\UserService;
// use App\Services\RoleService;
use Illuminate\Http\Request;


class AuthenticationService
{
    public static function retrieveUserAuthentication($user){
        $user = UserService::validateUser($user);

     
        $login_response['email'] = $user->email_address;
        $login_response['login_token'] = $user->login_token;  
        // $login_response['tenant_apps'] = $tenant_apps;
        // $login_response['tenant_info'] = $tenant;
        // if($user->is_tenant == true) {
        //     $login_response['app_access'] = $tenant_apps;
        // }

        $user_accesses = UserService::getUserAccess($user);
        foreach ($user_accesses as $user_access) { 
            $login_response['user_access'][] = $user_access;
        }                     
        
        $login_response['user'] = $user;
        return $login_response;
    }
}