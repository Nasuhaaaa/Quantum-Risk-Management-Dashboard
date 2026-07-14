<?php

namespace App\Http\Controllers;

use App\Support\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::lower($request->input('username')).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'username' => "Terlalu banyak percubaan. Sila cuba lagi dalam {$seconds} saat."
            ])->onlyInput('username');
        }

        if (Auth::attempt(['username' => $validated['username'], 'password' => $validated['password']], $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            AuditLogger::log(
                action: 'login',
                module: 'Pengesahan',
                description: 'Pengguna berjaya log masuk.'
            );

            return redirect()->route('dashboard');
        }

        RateLimiter::hit($throttleKey, 60);

        AuditLogger::log(
            action: 'login_failed',
            module: 'Pengesahan',
            description: 'Percubaan log masuk gagal.',
            username: $validated['username']
        );

        return back()->withErrors([
            'username' => 'Kredensial tidak sah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        AuditLogger::log(
            action: 'logout',
            module: 'Pengesahan',
            description: 'Pengguna log keluar.'
        );

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
