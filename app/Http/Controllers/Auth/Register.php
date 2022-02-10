<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;


class Register extends Controller
{

    public function register(Request $request)
    {
        try {
            $rules = [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users,email_address',
                'phone' => 'required|digits:11',
                'password' => 'required|min:6',
                'user_type' => 'required'  
            ];

            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->respondWithErrorMessage($validator);
            }

            UserService::createUser($request);

            return response()->json([
                'status'    => true
            ], 200);
        } catch (\Exception $exception) {
            report($exception);

            return response()->json([
                'status'   => false,
                'message'   => $exception->getMessage()
            ], 400);
        }
    }
}
