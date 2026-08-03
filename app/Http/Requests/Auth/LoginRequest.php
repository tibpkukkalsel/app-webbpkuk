<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            $attempts = RateLimiter::attempts($this->throttleKey()) + 1;

            // Penentuan durasi penalti (lockout) secara bertahap / eksponensial:
            // Percobaan 1-5  : Penalti 1 Menit (60s)
            // Percobaan 6    : Penalti 5 Menit (300s)
            // Percobaan 7    : Penalti 15 Menit (900s)
            // Percobaan 8+   : Penalti 60 Menit (3600s / 1 Jam)
            if ($attempts >= 8) {
                $decaySeconds = 3600; // 1 Jam
            } elseif ($attempts == 7) {
                $decaySeconds = 900;  // 15 Menit
            } elseif ($attempts == 6) {
                $decaySeconds = 300;  // 5 Menit
            } else {
                $decaySeconds = 60;   // 1 Menit default
            }

            RateLimiter::hit($this->throttleKey(), $decaySeconds);

            $sisaPercobaan = 5 - $attempts;
            $pesanEror = trans('auth.failed');

            if ($sisaPercobaan > 0) {
                $pesanEror .= " (Sisa percobaan login: {$sisaPercobaan}x sebelum akun/perangkat terkunci).";
            }

            throw ValidationException::withMessages([
                'email' => $pesanEror,
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());
        $minutes = ceil($seconds / 60);

        if ($seconds >= 60) {
            $waktuTunggu = "{$minutes} menit";
        } else {
            $waktuTunggu = "{$seconds} detik";
        }

        throw ValidationException::withMessages([
            'email' => "Terlalu banyak percobaan login yang salah. Perangkat/Akun terkunci sementara. Silakan tunggu {$waktuTunggu} sebelum mencoba login kembali.",
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
