<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|exists:users,email',
            'password' => 'required|min:6|string'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        return response()->json([
            'user' => $user,
            'access_token' => $user->createToken('Personal Access Token')
                ->accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'surname' => 'required|string',
            'email' => 'required|email|string|unique:users',
            'password' => 'required|min:6|string|confirmed',
            'img_url' => 'required|image'
        ]);
        if ($validator->fails()){return response()->json($validator->errors(), 400);}

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'img_url' => $request->img_url->store('/images/profil_img', 'attachment')
        ]);

        return response()->json([
            'result' => 'Ok',
            'message' => 'User was registered.',
            'user' => $user,
            'access_token' => $user->createToken('Personal Access Token')
                ->accessToken,
            'token_type' => 'Bearer'
        ]);
    }
}
