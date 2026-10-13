@extends('layouts.site-layout')

@section('title', 'Reset Password | Food Website')

@section('content')

<style>
    .food-reset-page {
        min-height: 75vh;
        padding: 70px 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fffaf5;
    }

    .food-reset-card {
        width: 100%;
        max-width: 480px;
        padding: 42px;
        background: #fff;
        border: 1px solid #f2eee9;
        border-radius: 20px;
        box-shadow: 0 15px 50px rgba(7, 27, 44, .10);
    }

    .food-reset-icon {
        width: 70px;
        height: 70px;
        margin: 0 auto 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #fff0e3;
        color: #e53935;
        font-size: 28px;
    }

    .food-reset-card h2 {
        margin-bottom: 12px;
        color: #071b2c;
        font-size: 29px;
        font-weight: 700;
        text-align: center;
    }

    .food-reset-description {
        margin-bottom: 28px;
        color: #777;
        font-size: 14px;
        line-height: 1.7;
        text-align: center;
    }

    .food-reset-field {
        margin-bottom: 19px;
    }

    .food-reset-field label {
        display: block;
        margin-bottom: 8px;
        color: #222;
        font-size: 13px;
        font-weight: 600;
    }

    .food-reset-input-wrap {
        width: 100%;
        height: 50px;
        display: flex;
        align-items: center;
        padding: 0 14px;
        border: 1px solid #e5e5e5;
        border-radius: 9px;
        background: #ffffff !important;
        transition: .3s ease;
        box-sizing: border-box;
    }

    .food-reset-input-wrap:focus-within {
        border-color: #e53935;
        box-shadow: 0 0 0 3px rgba(229, 57, 53, .08);
    }

    .food-reset-input-wrap > i:first-child {
        flex: 0 0 auto;
        margin-right: 11px;
        color: #999;
        font-size: 14px;
    }

    /* FIX: typed text always visible */
    .food-reset-page input.food-reset-input,
    .food-reset-page input.food-reset-input:focus,
    .food-reset-page input.food-reset-input:hover {
        flex: 1 1 auto;
        width: 100%;
        min-width: 0;
        height: 100%;
        margin: 0;
        padding: 0;
        border: none !important;
        outline: none !important;
        background: transparent !important;
        color: #222222 !important;
        -webkit-text-fill-color: #222222 !important;
        caret-color: #e53935 !important;
        font-family: inherit;
        font-size: 14px;
        font-weight: 500;
        line-height: normal;
        opacity: 1 !important;
        visibility: visible !important;
        box-shadow: none !important;
    }

    .food-reset-page input.food-reset-input::placeholder {
        color: #999999 !important;
        -webkit-text-fill-color: #999999 !important;
        opacity: 1 !important;
    }

    .food-reset-page input.food-reset-input:-webkit-autofill,
    .food-reset-page input.food-reset-input:-webkit-autofill:hover,
    .food-reset-page input.food-reset-input:-webkit-autofill:focus {
        -webkit-text-fill-color: #222222 !important;
        caret-color: #e53935 !important;
        transition: background-color 99999s ease-in-out 0s;
    }

    .food-reset-toggle {
        flex: 0 0 32px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 8px;
        padding: 0;
        border: 0;
        outline: none;
        background: transparent !important;
        color: #999;
        cursor: pointer;
        box-shadow: none !important;
    }

    .food-reset-toggle i {
        color: inherit;
        -webkit-text-fill-color: currentColor;
    }

    .food-reset-toggle:hover {
        color: #e53935;
    }

    .food-reset-btn {
        width: 100%;
        min-height: 50px;
        margin-top: 8px;
        border: 0;
        border-radius: 9px;
        background: linear-gradient(135deg, #ff8c1a, #e53935);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .3s ease;
    }

    .food-reset-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(229, 57, 53, .18);
    }

    .food-reset-back {
        display: block;
        margin-top: 24px;
        color: #e53935;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
    }

    .food-reset-back:hover {
        color: #c62828;
    }

    .food-reset-alert {
        padding: 12px 14px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-size: 13px;
        line-height: 1.6;
    }

    .food-reset-alert.error {
        background: #fff0f0;
        border: 1px solid #ffd1d1;
        color: #b42318;
    }

    .food-reset-alert.success {
        background: #effaf1;
        border: 1px solid #ccebd2;
        color: #18743a;
    }

    .food-reset-invalid {
        margin-top: 6px;
        color: #d92d20;
        font-size: 12px;
    }

    @media (max-width: 576px) {
        .food-reset-page {
            padding: 40px 15px;
        }

        .food-reset-card {
            padding: 30px 22px;
        }

        .food-reset-card h2 {
            font-size: 25px;
        }
    }
</style>

<div class="food-reset-page">
    <div class="food-reset-card">

        <div class="food-reset-icon">
            <i class="far fa-lock"></i>
        </div>

        <h2>Reset Password</h2>

        <p class="food-reset-description">
            Create a strong new password for your account.
            Make sure both password fields match.
        </p>

        {{-- SUCCESS MESSAGE --}}
        @if (session('status'))
            <div class="food-reset-alert success">
                {{ session('status') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div class="food-reset-alert error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            {{-- RESET TOKEN --}}
            <input
                type="hidden"
                name="token"
                value="{{ $token ?? request()->route('token') }}"
            >

            {{-- EMAIL --}}
            <div class="food-reset-field">
                <label for="resetEmail">Email Address</label>

                <div class="food-reset-input-wrap">
                    <i class="far fa-envelope"></i>

                    <input
                        type="email"
                        id="resetEmail"
                        name="email"
                        class="food-reset-input"
                        placeholder="Enter your email address"
                        value="{{ old('email', $email ?? request()->query('email')) }}"
                        autocomplete="email"
                        required
                    >
                </div>

                @error('email')
                    <div class="food-reset-invalid">{{ $message }}</div>
                @enderror
            </div>

            {{-- NEW PASSWORD --}}
            <div class="food-reset-field">
                <label for="newPassword">New Password</label>

                <div class="food-reset-input-wrap">
                    <i class="far fa-lock"></i>

                    <input
                        type="password"
                        id="newPassword"
                        name="password"
                        class="food-reset-input"
                        placeholder="Enter new password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="food-reset-toggle"
                        data-target="newPassword"
                        aria-label="Show new password"
                    >
                        <i class="far fa-eye"></i>
                    </button>
                </div>

                @error('password')
                    <div class="food-reset-invalid">{{ $message }}</div>
                @enderror
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="food-reset-field">
                <label for="confirmPassword">Confirm New Password</label>

                <div class="food-reset-input-wrap">
                    <i class="far fa-lock"></i>

                    <input
                        type="password"
                        id="confirmPassword"
                        name="password_confirmation"
                        class="food-reset-input"
                        placeholder="Confirm new password"
                        autocomplete="new-password"
                        minlength="8"
                        required
                    >

                    <button
                        type="button"
                        class="food-reset-toggle"
                        data-target="confirmPassword"
                        aria-label="Show confirm password"
                    >
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="food-reset-btn">
                Reset Password
                <i class="far fa-arrow-right ms-2"></i>
            </button>
        </form>

        <a href="{{ route('login') }}" class="food-reset-back">
            <i class="far fa-arrow-left me-1"></i>
            Back to Login
        </a>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.food-reset-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(
                button.getAttribute('data-target')
            );

            if (!input) {
                return;
            }

            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';

                if (icon) {
                    icon.className = 'far fa-eye-slash';
                }

                button.setAttribute('aria-label', 'Hide password');
            } else {
                input.type = 'password';

                if (icon) {
                    icon.className = 'far fa-eye';
                }

                button.setAttribute('aria-label', 'Show password');
            }
        });
    });
});
</script>

@endsection
