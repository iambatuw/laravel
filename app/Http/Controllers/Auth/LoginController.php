<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre zorunludur.',
        ]);

        $turnstileEnabled = filled(config('services.turnstile.secret_key')) && filled(config('services.turnstile.site_key'));
        if ($turnstileEnabled) {
            $token = (string) $request->input('cf-turnstile-response', '');

            if ($token === '') {
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => 'Güvenlik doğrulamasını tamamlayınız.']);
            }

            $verificationResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            if (! $verificationResponse->successful() || ! $verificationResponse->json('success')) {
                return back()
                    ->withInput($request->only('email', 'remember'))
                    ->withErrors(['email' => 'Robot doğrulaması başarısız oldu. Tekrar deneyiniz.']);
            }
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Başarıyla giriş yaptınız. Hoş geldiniz, '.auth()->user()->name.'!');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => 'E-posta adresi veya şifre hatalı.',
            ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
