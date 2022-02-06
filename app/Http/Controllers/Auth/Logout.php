<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\GeneralHelper;
use App\Models\User;

class Logout extends Controller
{
    protected $user;
    
    public function __construct(Request $request)
    {
        $this->user = GeneralHelper::getActiveUser($request);
    }

    public function index()
    {
        $user = User::where([
            'email_address' => $this->user->email_address,
        ])->first();

        $user->login_token = NULL;
        $user->save();

        // $log = [
        //     'type' => 'logout',
        //     'action' => $user->firstname." ".$user->lastname." logged out.",
        //     'user_id' => $user->id,
        //     'tenant_id' => $user->tenant_id
        // ];
        // Log::store($log);

        return response()->json([
            'status' => true,
            'message' => 'You\'ve successfully logged out'
        ]);
    }
}
