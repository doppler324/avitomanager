<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Validator;
use App\Http\Requests\registerRequest;
use App\Http\Requests\loginRequest;

class AuthController extends Controller
{
    public function register(Request $request, registerRequest $req)
    {
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        if($user->save()){
            return response()->json([
                'message' => 'Пользователь успешно зарегистрирован!'
            ], 201);
        }else{
            return response()->json(['error'=>'Ошибка при регистрации пользователя']);
        }
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request, loginRequest $req)
    {

        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Неавторизован: email или пароль не найдены'
            ], 401);
        $token = $request->user()->createToken("token request");
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        return response()->json($token);
        $token->save();
        return response()->json([
            'access_token' => $token->plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $token->accessToken->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Успешный выход'
        ]);
    }
}
