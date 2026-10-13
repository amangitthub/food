<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;

class ForgotPasswordController extends Controller
{
    // Forgot Password page
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Send reset link to email
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::ResetLinkSent) {
            return back()->with('status', __($status));
        }

        return back()->withErrors([
            'email' => __($status),
        ]);
    }

    // Open Reset Password page from email link
    public function showResetForm(Request $request, string $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // Save new password and automatically log in the user
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8),
            ],
        ]);

        // Store the exact user whose password is reset
        $resetUser = null;

        $status = Password::reset(
            $validated,
            function (User $user, string $password) use (&$resetUser) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                $resetUser = $user;
            }
        );

        if ($status === Password::PasswordReset) {

            // Automatically log in after successful password reset
            if ($resetUser) {
                Auth::login($resetUser);

                // Regenerate session for security
                $request->session()->regenerate();
            }

            return redirect('/')
                ->with(
                    'password_reset_success',
                    'Password reset successfully! You are now logged in.'
                );
        }

        // Reset failed: show the error
        return back()
            ->withErrors([
                'email' => __($status),
            ])
            ->withInput($request->only('email'));
    }
}
