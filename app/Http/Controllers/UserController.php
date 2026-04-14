<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->password = $request->password;
        $path = Storage::disk("public")->putFile("avatars", $request->file("avatar"));
        $user->avatar = $path;
        $user->save();
        return response()->json(["token" => $user->createToken("api")->plainTextToken]);
    }
    public function auth(UserAuthRequest $request)
{
    $user = User::where('username', $request->username)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'ok',
            'errors' => [
                'password' => ['Неверный логин или пароль']
            ]
        ]);
    }
    return response()->json([
        'token' => $user->createToken('api')->plainTextToken
    ]);
}
public function logout(Request $request)
{
    $request -> user()->currentAccessToken()->delete();
    return response()->json(['message' => 'ok',]);
}
}
