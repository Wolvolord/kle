<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'user_code' => $this->generateUserCode(),
            'name'      => $request->full_name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        Auth::login($user);

        ActivityLog::record('register', "'{$user->name}' sisteme kaydoldu.", 'User', $user->id, $user->name);

        return redirect('/');
    }

    private function generateUserCode(): string
    {
        do {
            $code = (string) random_int(1, 9);
            for ($i = 0; $i < 18; $i++) {
                $code .= random_int(0, 9);
            }
        } while (User::where('user_code', $code)->exists());

        return $code;
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            ActivityLog::record('login', "'{$user->name}' oturum açtı.", 'User', $user->id, $user->name);

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'E-posta veya şifre hatalı.',
        ]);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            ActivityLog::record('logout', "'{$user->name}' oturumu kapattı.", 'User', $user->id, $user->name);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
