<?php

namespace App\Http\Controllers\Auth;

use App\User;
use PasswordHash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    function register(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:5',
                'name' => 'required|string',
                'role' => 'required|string'
            ]);
            $email = $request->email;
            if (!in_array($request->role, ['student', 'teacher']))
                return $this->respondWithTemplate(false, null, 'سوزنم فکر میکرد تیزه', 406);

            if (User::where('email', $email)->exists()) {
                return $this->respondWithTemplate(false, null, 'این ایمیل توسط کاربر دیگری ثبت شده است ');
            }



            $user = User::create([
                'name' => $request->name,
                'email' => $email,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);

            $token = auth()->login(User::find($user->id), true);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {


            return $this->respondWithTemplate(false, null,  $e->getMessage());
        }
    }
    public function login(Request $request)
    {
        $token = $this->attemptLogin($request);

        if (gettype($token) != 'string' && gettype($token) != 'boolean') {
            return $token;
        }
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $response = $this->respondWithToken($token);

        return $response;
    }


    private function attemptLogin(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return $this->respondWithTemplate(false, [], 'کاربری یافت نشد');
        }
        $check = Hash::check($request->password, $user->password);

        if (!$check) {
            return false;
        }

        return auth()->login($user, true);
    }
    public function me()
    {
        $user= User::findOrFail(Auth::id());
        return $this->respondWithTemplate(true, $user);
    }
}
