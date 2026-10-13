@extends('layouts.site-layout')

@section('title', 'Forgot Password | Food Website')

@section('content')

<style>
.food-forgot-page {
    min-height: 75vh;
    padding: 70px 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fffaf5;
}

.food-forgot-card {
    width: 100%;
    max-width: 480px;
    background: #fff;
    border-radius: 20px;
    padding: 42px;
    box-shadow: 0 15px 50px rgba(7, 27, 44, .10);
    border: 1px solid #f2eee9;
}

.food-forgot-icon {
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

.food-forgot-card h2 {
    color: #071b2c;
    font-size: 29px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 12px;
}

.food-forgot-description {
    color: #777;
    text-align: center;
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 28px;
}

.food-forgot-label {
    display: block;
    color: #222;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
}

.food-forgot-input {
    display: block !important;
    width: 100% !important;
    height: 50px !important;
    border: 1px solid #e5e5e5 !important;
    border-radius: 9px !important;
    padding: 0 15px !important;
    outline: none !important;
    font-size: 14px !important;
    font-family: inherit !important;
    font-weight: 400 !important;

    /* Email typing text visibility fix */
    color: #071b2c !important;
    -webkit-text-fill-color: #071b2c !important;
    background-color: #ffffff !important;
    opacity: 1 !important;
    visibility: visible !important;
    caret-color: #071b2c !important;

    transition: .3s ease;
    box-shadow: none;
}

.food-forgot-input::placeholder {
    color: #888888 !important;
    -webkit-text-fill-color: #888888 !important;
    opacity: 1 !important;
}

.food-forgot-input:focus {
    border-color: #e53935 !important;
    color: #071b2c !important;
    -webkit-text-fill-color: #071b2c !important;
    background-color: #ffffff !important;
    box-shadow: 0 0 0 3px rgba(229, 57, 53, .08) !important;
}

.food-forgot-btn {
    width: 100%;
    min-height: 50px;
    margin-top: 20px;
    border: 0;
    border-radius: 9px;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    background: linear-gradient(135deg, #ff8c1a, #e53935);
    transition: .3s ease;
    cursor: pointer;
}

.food-forgot-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(229, 57, 53, .18);
}

.food-forgot-back {
    display: block;
    text-align: center;
    margin-top: 24px;
    color: #e53935;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.food-forgot-back:hover {
    color: #c62828;
}

@media (max-width: 576px) {
    .food-forgot-page {
        padding: 40px 15px;
    }

    .food-forgot-card {
        padding: 30px 22px;
    }

    .food-forgot-card h2 {
        font-size: 25px;
    }
}
</style>

<div class="food-forgot-page">
    <div class="food-forgot-card">

        <div class="food-forgot-icon">
            <i class="far fa-lock"></i>
        </div>

        <h2>Forgot Password?</h2>

        <p class="food-forgot-description">
            No worries! Enter your registered email address.
            We'll help you get back into your account.
        </p>

        {{-- SUCCESS MESSAGE --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- FRONT-END FORM --}}
        <form action="{{ url('/forgot-password') }}" method="POST">
            @csrf

            <label for="forgotEmail" class="food-forgot-label">
                Email Address
            </label>

            <input
                type="email"
                name="email"
                id="forgotEmail"
                class="food-forgot-input"
                placeholder="Enter your registered email"
                value="{{ old('email') }}"
                autocomplete="email"
                required
            >

            <button type="submit" class="food-forgot-btn">
                Send Reset Link
                <i class="far fa-arrow-right ms-2"></i>
            </button>
        </form>

        <a href="{{ url('/') }}" class="food-forgot-back">
            <i class="far fa-arrow-left me-1"></i>
            Back to Website
        </a>

    </div>
</div>

@endsection
