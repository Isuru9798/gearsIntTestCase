<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    function store(Request $request)
    {
        // validating the request
        $rules = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);

        // if validation failed send response to front
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            User::create([
                'f_name' => $request->first_name,
                'l_name' => $request->last_name,
                'role' => env('AUTHOR'),
                'status' => env('ACTIVE'),
                'email' => $request->email,
                'password' => $request->password,
            ]);
            return response()->json([
                'message' => 'you are registered as a author!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Unable to register please try again later!'
            ], 400);
        }
    }
}