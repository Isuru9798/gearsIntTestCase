<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // validating the request
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ];

        $validator = Validator::make($request->all(), $rules);

        // if validation failed send response to front
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        // login attempt
        if (
            !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => env('AUTHOR')])
        ) {
            // if login credentials faild, send response
            return response([
                'message' => 'invalid login credentials.'
            ]);
        }

        // check author status 
        if (Auth::user()->status == env('INACTIVE')) {
            return response([
                'message' => 'your account has been disabled.'
            ]);
        }

        // genarate token
        $assessToken = Auth::user()->createToken('authToken')->accessToken;

        // sending respons
        return response([
            'user_id' => Auth::user()->id, // get logged user id
            'access_token' => "Bearer " . $assessToken
        ]);
    }
    public function adminLogin(Request $request)
    {
        $rules = [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (
            !Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => env('ADMIN')])
        ) {
            return response([
                'message' => 'invalid login credentials. '
            ]);
        }
        $assessToken = Auth::user()->createToken('authToken')
            ->accessToken;

        return response([
            'user_id' => Auth::user()->id,
            'access_token' => "Bearer " . $assessToken
        ]);
    }
}
