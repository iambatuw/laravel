<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PasswordResetController extends Controller
{
    public function showForm()
    {
        return view('auth.reset');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Yeni şifre zorunludur.',
            'password.min' => 'Yeni şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Yeni şifre tekrarı eşleşmiyor.',
        ]);

        $turnstileEnabled = filled(config('services.turnstile.secret_key')) && filled(config('services.turnstile.site_key'));
        if ($turnstileEnabled) {
            $token = (string) $request->input('cf-turnstile-response', '');

            if ($token === '') {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Güvenlik doğrulamasını tamamlayınız.']);
            }

            $verificationResponse = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $token,
                'remoteip' => $request->ip(),
            ]);

            if (! $verificationResponse->successful() || ! $verificationResponse->json('success')) {
                return back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => 'Robot doğrulaması başarısız oldu. Tekrar deneyiniz.']);
            }
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return redirect()
                ->route('login')
                ->with('success', 'Eğer bu e-posta adresi sistemde kayıtlıysa şifreniz güncellendi.');
        }

        $user->update([
            'password' => Hash::make((string) $request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Şifreniz başarıyla güncellendi. Yeni şifrenizle giriş yapabilirsiniz.');
    }
}
