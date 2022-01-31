<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\AuthenticationService;


class Login extends Controller
{
    public function index(Request $request)
    {
        $login_response = [];

        $user = User::where([
            'email_address' => $request->email,
        ])->first();

        if($user && Hash::check($request->password, $user->password)) {

            if($user->status == "inactive") {
                return response()->json([
                    'status'    => 'false',
                    'message'   => 'Account is inactive'
                ], 401);
            }

            $token = Str::random(64);
            $user->login_token = $token;
            $user->save();
            // $log = [
            //     'type' => 'login',
            //     'action' => $user->firstname." ".$user->lastname." logged in.",
            //     'user_id' => $user->id,
            //     'tenant_id' => $user->tenant_id
            // ];
            // Log::store($log);
            $login_response = AuthenticationService::retrieveUserAuthentication($user);
            return response()->json([
                'status' => true,
                'data' => $login_response
            ]);
        }

        return response()->json([
            'status'    => 'false',
            'message'   => 'Invalid login credentials'
        ],401);
    }
}