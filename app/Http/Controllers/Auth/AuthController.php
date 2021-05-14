<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   
    function register(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
                'name' => 'required|string',
                'role' => 'required|string'
            ]);
            $email = $request->email;
            if (User::where('email', $email)->exists()) {
                return $this->respondWithTemplate(false, null, 'این ایمیل توسط کاربر دیگری ثبت شده است ');
            }


            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'role' => User::ROLE[$request->role],
                'password' => bcrypt($request->password)
            ]);

            $token = auth()->login(User::find($user->id), true);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->respondWithTemplate(false, null,  $e->getMessage());
        }
    }
}
