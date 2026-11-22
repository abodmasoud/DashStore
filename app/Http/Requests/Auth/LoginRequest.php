<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Shared login request for customers and admins.
 * Locks an email/IP pair out for a minute after 5 failed attempts.
 */
class LoginRequest extends FormRequest
{
    public const MAX_ATTEMPTS = 5;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * @throws ValidationException
     */
    public function authenticate(string $guard = 'web'): void
    {
        $this->ensureIsNotRateLimited($guard);

        if (! Auth::guard($guard)->attempt($this->only('email', 'password'), $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey($guard));

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($guard));
    }

    protected function ensureIsNotRateLimited(string $guard): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($guard), self::MAX_ATTEMPTS)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey($guard));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(string $guard): string
    {
        return $guard.'|'.Str::transliterate(Str::lower($this->string('email')).'|'.$this->ip());
    }
}
