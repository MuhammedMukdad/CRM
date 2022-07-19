<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\LoginRequest as APILoginRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class userController extends BaseController
{
    public function register(UserRegisterRequest $request)
    {
        $request['password'] = Hash::make($request->password);

        $user = Employee::create($request->all());
        $user->save();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }

    public function login(APILoginRequest $request)
    {

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::make($request->password) == $user->password) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }


        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'user' => $user,
            'access_token' => $token,
        ]);
    }
}
