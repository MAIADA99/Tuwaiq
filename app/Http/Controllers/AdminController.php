<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $responvalidator = Validator::make($request->all(),[
            'email' =>'required|email|max:100|exists:users,email',
            'password' =>'required|string|min:6',
        ]);

        if ($responvalidator->fails()) {
            return response()->json(['message' => $responvalidator->errors()], 400);
        }

        // if true create token
        if (! $token = auth()->attempt($responvalidator->validated())) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        return $this->createNewToken($token);
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60,
            //user data that front need hello admin
            'user' => ['name'=>auth()->user()->name]
        ]);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out'],200);

    }

}
