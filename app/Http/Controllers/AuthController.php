<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Page
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        return redirect('/');
    }

    /*
    |--------------------------------------------------------------------------
    | Login
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'The email or password is incorrect.',
                ])
                ->withInput($request->only('email'));
        }

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Check User Status
        |--------------------------------------------------------------------------
        */
        if ($user->status !== 'active') {
            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'Your account is currently inactive.',
                ])
                ->withInput($request->only('email'));
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */
        $request->session()->regenerate();

        /*
        |--------------------------------------------------------------------------
        | Admin Login
        |--------------------------------------------------------------------------
        */
        if ($user->role === 'admin') {
            return redirect('/dashboard')
                ->with(
                    'login_success',
                    'Welcome to Admin Dashboard.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Normal User Login
        |--------------------------------------------------------------------------
        */
        // return redirect('/')
        //     ->with(
        //         'login_success',
        //         'Welcome back! You have logged in successfully.'
        //     );


        /*
        |--------------------------------------------------------------------------
        | Normal User Login
        |--------------------------------------------------------------------------
        */


        $redirect = $request->input('redirect');

        if (
            is_string($redirect) &&
            str_starts_with($redirect, '/') &&
            !str_starts_with($redirect, '//') &&
            !str_contains($redirect, '\\')
        ) {
            return redirect()->to($redirect)->with(
                'login_success',
                'Welcome back! You have logged in successfully.'
            );
        }

        return redirect('/')
            ->with(
                'login_success',
                'Welcome back! You have logged in successfully.'
            );

    }

    /*
    |--------------------------------------------------------------------------
    | Register Page
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return redirect('/');
    }

    /*
    |--------------------------------------------------------------------------
    | Register
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $validated = $request->validateWithBag('register', [
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'mobile' => [
                'required',
                'string',
                'regex:/^[0-9]{10,15}$/',
                'unique:users,mobile',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
        ], [
            'mobile.required' => 'Please enter your mobile number.',
            'mobile.regex' => 'Mobile number must contain 10 to 15 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')
            ->with(
                'register_success',
                'Account created successfully.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')
            ->with(
                'success',
                'You have been logged out successfully.'
            );
    }
}
