@extends('layouts.site-layout')

@section('title', 'My Profile | Food Website')

@section('meta_description', 'Manage your profile and saved addresses.')

@section('content')

<style>
    .food-profile-page {
        --p-orange: #FF6B35;
        --p-orange-light: #FF986B;
        --p-orange-dark: #C2410C;
        --p-purple: #FF6B35;
        --p-purple-dark: #C2410C;
        --p-navy: #ff5e00;
        --p-muted: #82736B;
        --p-border: #F2DFD5;

        position: relative;
        isolation: isolate;
        overflow: hidden;
        min-height: 75vh;
        padding: 55px 0 75px;

        background:
            radial-gradient(ellipse at 5% 10%, rgba(255, 107, 53, .12), transparent 32%),
            radial-gradient(ellipse at 95% 45%, rgba(255, 107, 53, .09), transparent 34%),
            #FFFAF7;

        font-family: "Plus Jakarta Sans", "Inter", sans-serif;
        color: var(--p-navy);
    }

    .food-profile-page *,
    .food-profile-page *::before,
    .food-profile-page *::after {
        box-sizing: border-box;
    }

    .food-profile-page::before,
    .food-profile-page::after {
        content: "";
        position: absolute;
        z-index: -1;
        pointer-events: none;
        border-radius: 50%;
    }

    .food-profile-page::before {
        width: 300px;
        height: 300px;
        top: 220px;
        left: -220px;
        border: 50px solid rgba(255, 107, 53, .07);
        animation: profile-orbit 16s ease-in-out infinite alternate;
    }

    .food-profile-page::after {
        width: 250px;
        height: 250px;
        right: -180px;
        bottom: 45px;
        border: 42px solid rgba(255, 107, 53, .07);
        animation: profile-orbit 13s ease-in-out infinite alternate-reverse;
    }

    @keyframes profile-orbit {
        from {
            transform: translate3d(0, 0, 0) rotate(0deg);
        }

        to {
            transform: translate3d(18px, -22px, 0) rotate(30deg);
        }
    }

    @keyframes profile-enter {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes profile-glow {

        0%,
        100% {
            box-shadow: 0 0 0 4px rgba(255, 107, 53, .10),
                0 8px 24px rgba(255, 107, 53, .18);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(255, 107, 53, .07),
                0 8px 30px rgba(194, 65, 12, .22);
        }
    }

    .food-profile-page .container {
        position: relative;
        z-index: 1;
    }

    /* HERO */
    .food-profile-page .profile-heading {
        position: relative;
        overflow: hidden;
        isolation: isolate;
        padding: 38px 36px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, .15);
        border-radius: 24px;

        background:
            radial-gradient(circle at 90% 5%, rgba(255, 220, 150, .22), transparent 35%),
            linear-gradient(115deg, #FA6028 0%, #FC6F3C 55%, #FF9638 82%, #FFC857 100%);

        box-shadow: 0 17px 40px rgba(194, 65, 12, .19);
        animation: profile-enter .6s ease both;
    }

    .food-profile-page .profile-heading::before {
        content: "";
        position: absolute;
        z-index: -1;
        width: 290px;
        height: 290px;
        top: -205px;
        right: -30px;
        border: 45px solid rgba(255, 255, 255, .10);
        border-radius: 50%;
        box-shadow: 0 0 0 30px rgba(255, 255, 255, .035);
        pointer-events: none;
    }

    .food-profile-page .profile-heading::after {
        content: "";
        position: absolute;
        z-index: -1;
        width: 90px;
        height: 90px;
        right: 19%;
        bottom: -65px;
        border-radius: 25px;
        background: rgba(255, 237, 213, .13);
        transform: rotate(35deg);
        pointer-events: none;
    }

    .food-profile-page .profile-heading .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 14px;
        color: #FFF0E5;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: 2.5px;
        text-transform: uppercase;
    }

    .food-profile-page .profile-heading .eyebrow::before {
        content: "";
        width: 25px;
        height: 3px;
        border-radius: 5px;
        background: #FFD0A8;
    }

    .food-profile-page .profile-heading h2 {
        position: relative;
        margin: 0 0 12px;
        color: #fff;
        font-size: clamp(30px, 4vw, 42px);
        font-weight: 850;
        line-height: 1.25;
        letter-spacing: -1px;
    }

    .food-profile-page .profile-heading p {
        position: relative;
        max-width: 580px;
        margin: 0;
        color: #FFF0E5;
        font-size: 15px;
        line-height: 1.9;
    }

    /* PROFILE CARDS */
    .food-profile-page .profile-layout {
        align-items: stretch;
    }

    .food-profile-page .food-profile-card {
        position: relative;
        height: 100%;
        padding: 29px;
        margin-bottom: 24px;
        overflow: hidden;

        border: 1px solid var(--p-border);
        border-radius: 21px;
        background: rgba(255, 255, 255, .97);
        box-shadow: 0 10px 32px rgba(100, 49, 20, .055);

        animation: profile-enter .65s ease both;
        transition: border-color .3s ease,
            box-shadow .3s ease,
            transform .3s ease;
    }

    .food-profile-page .profile-layout>div:first-child .food-profile-card {
        animation-delay: .08s;
    }

    .food-profile-page .profile-layout>div:last-child .food-profile-card {
        animation-delay: .17s;
    }

    .food-profile-page .food-profile-card:hover {
        border-color: #FFC6AA;
        box-shadow: 0 16px 38px rgba(154, 52, 18, .08);
    }

    /* USER PANEL */
    .food-profile-page .profile-user-box {
        position: relative;
        display: flex;
        align-items: center;
        gap: 20px;
        min-width: 0;
        padding: 26px;
        margin-bottom: 34px;
        overflow: hidden;

        border: 1px solid #FFD9C7;
        border-radius: 19px;

        background:
            radial-gradient(circle at 100% 0%, rgba(255, 107, 53, .12), transparent 38%),
            linear-gradient(120deg, #FFF0E7 0%, #FFFAF6 100%);
    }

    .food-profile-page .profile-user-box::after {
        content: "";
        position: absolute;
        width: 125px;
        height: 125px;
        right: -65px;
        top: -63px;
        border: 23px solid rgba(255, 107, 53, .10);
        border-radius: 50%;
        pointer-events: none;
    }

    .food-profile-page .profile-avatar {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 76px;
        height: 76px;
        border: 3px solid rgba(255, 255, 255, .9);
        border-radius: 23px;

        background: linear-gradient(140deg, #FFAD78, #FF6B35 50%, #D94B24);
        color: #fff;
        font-size: 29px;

        animation: profile-glow 4s ease-in-out infinite;
        transition: border-radius .3s ease, transform .3s ease;
    }

    .food-profile-page .profile-user-box:hover .profile-avatar {
        border-radius: 50%;
        transform: rotate(-5deg);
    }

    .food-profile-page .profile-user-info {
        position: relative;
        z-index: 1;
        min-width: 0;
    }

    .food-profile-page .profile-user-name {
        margin-bottom: 6px;
        color: #321710;
        font-size: 24px;
        font-weight: 850;
        line-height: 1.4;
        letter-spacing: -.5px;
        overflow-wrap: anywhere;
    }

    .food-profile-page .profile-user-email {
        color: #82736B;
        font-size: 15px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .food-profile-page .profile-status {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 7px 13px;
        margin-top: 12px;
        border: 1px solid #C8EBD4;
        border-radius: 30px;
        background: #EDFFF2;
        color: #21854A;
        font-size: 12px;
        font-weight: 750;
    }

    /* SECTION HEADINGS */
    .food-profile-page .profile-card-heading {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 30px;
    }

    .food-profile-page .heading-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 54px;
        height: 54px;
        border: 1px solid #FFDCCB;
        border-radius: 16px;
        background: linear-gradient(145deg, #FFF0E5, #FFE0D0);
        color: #FF6B35;
        font-size: 22px;
        transition: transform .3s ease, border-radius .3s ease;
    }

    .food-profile-page .profile-card-heading:hover .heading-icon {
        transform: rotate(-7deg) scale(1.06);
        border-radius: 12px;
    }

    .food-profile-page .profile-card-heading h4 {
        margin: 2px 0 7px;
        color: #321710;
        font-size: 21px;
        font-weight: 850;
        line-height: 1.45;
        letter-spacing: -.45px;
    }

    .food-profile-page .section-subtitle {
        margin: 0;
        color: #82736B;
        font-size: 14px;
        line-height: 1.8;
    }

    /* FORM */
    .food-profile-page .form-label {
        display: inline-block;
        margin-bottom: 9px;
        color: #493326;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .1px;
    }

    .food-profile-page .form-control {
        display: block;
        width: 100%;
        min-height: 53px;
        padding: 14px 16px;
        border: 1px solid #EBDDD3;
        border-radius: 12px;
        background: #FFFDFA;
        color: #352016;
        font-size: 14px;
        box-shadow: none;

        transition: background .25s ease,
            border-color .25s ease,
            box-shadow .25s ease;
    }

    .food-profile-page .form-control::placeholder {
        color: #B4A59A;
        font-size: 14px;
        opacity: 1;
    }

    .food-profile-page .form-control:hover {
        border-color: #FFB99A;
        background: #fff;
    }

    .food-profile-page .form-control:focus {
        border-color: #FF6B35;
        outline: none;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(255, 107, 53, .13);
    }

    .food-profile-page .form-control.is-invalid {
        border-color: #dc3545;
    }

    .food-profile-page .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(220, 53, 69, .09);
    }

    .food-profile-page .invalid-feedback {
        display: block;
        margin-top: 8px;
        font-size: 13px;
    }

    .food-profile-page .field-hint {
        margin-top: 8px;
        color: #95877C;
        font-size: 12px;
        line-height: 1.8;
    }

    /* BUTTONS */
    .food-profile-page .food-btn {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        min-height: 49px;
        padding: 12px 23px;
        overflow: hidden;

        border: 1px solid transparent;
        border-radius: 12px;

        background: linear-gradient(110deg, #FF6B35, #FC7E3A 70%, #FF9A3C);
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        text-align: center;
        white-space: nowrap;
        cursor: pointer;

        box-shadow: 0 7px 18px rgba(255, 107, 53, .22);

        transition: transform .25s ease,
            box-shadow .25s ease,
            background .25s ease;
    }

    .food-profile-page .food-btn::before {
        content: "";
        position: absolute;
        top: -40%;
        left: -65%;
        width: 38%;
        height: 180%;
        background: rgba(255, 255, 255, .25);
        transform: rotate(22deg);
        transition: left .55s ease;
        pointer-events: none;
    }

    .food-profile-page .food-btn:hover::before {
        left: 130%;
    }

    .food-profile-page .food-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(255, 107, 53, .30);
        color: #fff;
    }

    .food-profile-page .food-btn:active {
        transform: translateY(0) scale(.98);
    }

    .food-profile-page .food-btn-outline {
        border-color: #EBD9CE;
        background: #fff;
        color: #70452D;
        box-shadow: none;
    }

    .food-profile-page .food-btn-outline:hover {
        border-color: #FFC5A8;
        background: #FFF3EC;
        color: #C2410C;
        box-shadow: 0 7px 18px rgba(255, 107, 53, .10);
    }

    .food-profile-page .profile-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
    }

    /* INFO BOX */
    .food-profile-page .profile-help-box {
        padding: 18px 19px;
        margin-top: 26px;
        border: 1px solid #F6DCCB;
        border-radius: 13px;
        background: linear-gradient(110deg, #FFF2E8, #FFFAF5);
        color: #806C5E;
        font-size: 14px;
        line-height: 1.9;
    }

    .food-profile-page .profile-help-box i {
        margin-right: 7px;
        color: #FF6B35;
    }

    /* SIDEBAR LINKS */
    .food-profile-page .profile-side-link {
        position: relative;
        display: flex;
        align-items: center;
        gap: 15px;
        min-width: 0;
        padding: 17px 14px;
        margin-top: 14px;
        overflow: hidden;

        border: 1px solid #EEE3D9;
        border-radius: 14px;
        background: #fff;
        color: #352016;
        text-decoration: none;

        transition: transform .25s ease,
            border-color .25s ease,
            box-shadow .25s ease,
            background .25s ease;
    }

    .food-profile-page .profile-side-link::before {
        content: "";
        position: absolute;
        top: 15%;
        bottom: 15%;
        left: 0;
        width: 3px;
        border-radius: 0 5px 5px 0;
        background: linear-gradient(#FF986B, #FF6B35);
        transform: scaleY(0);
        transition: transform .25s ease;
    }

    .food-profile-page .profile-side-link:hover {
        transform: translateX(3px);
        border-color: #FFC7AD;
        background: linear-gradient(105deg, #FFFAF6, #FFF0E7);
        box-shadow: 0 8px 20px rgba(154, 52, 18, .06);
        color: #352016;
    }

    .food-profile-page .profile-side-link:hover::before {
        transform: scaleY(1);
    }

    .food-profile-page .side-link-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 49px;
        height: 49px;
        border-radius: 14px;
        background: #FFF0E7;
        color: #FF6B35;
        font-size: 19px;
        transition: transform .3s ease,
            background .3s ease,
            color .3s ease;
    }

    .food-profile-page .profile-side-link:nth-of-type(2) .side-link-icon,
    .food-profile-page .profile-side-link:nth-of-type(3) .side-link-icon {
        background: #FFF0E7;
        color: #E95420;
    }

    .food-profile-page .profile-side-link:hover .side-link-icon {
        transform: rotate(-6deg) scale(1.07);
        background: linear-gradient(140deg, #FF986B, #FF6B35);
        color: #fff;
    }

    .food-profile-page .side-link-text {
        flex: 1;
        min-width: 0;
    }

    .food-profile-page .side-link-text strong {
        display: block;
        margin-bottom: 6px;
        color: inherit;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.5;
    }

    .food-profile-page .side-link-text small {
        display: block;
        color: #918278;
        font-size: 12px;
        line-height: 1.75;
    }

    .food-profile-page .side-link-arrow {
        flex-shrink: 0;
        color: #B4A194;
        font-size: 14px;
        transition: transform .25s ease, color .25s ease;
    }

    .food-profile-page .profile-side-link:hover .side-link-arrow {
        transform: translateX(4px);
        color: #FF6B35;
    }

    /* ALERTS */
    .food-profile-page .alert {
        border-radius: 13px;
        font-size: 14px;
        line-height: 1.8;
        animation: profile-enter .4s ease both;
    }

    .food-profile-page .alert ul {
        padding-left: 22px;
    }

    /* ACCESSIBILITY */
    .food-profile-page .food-btn:focus-visible,
    .food-profile-page .profile-side-link:focus-visible,
    .food-profile-page a:focus-visible,
    .food-profile-page button:focus-visible {
        outline: 3px solid rgba(255, 107, 53, .4);
        outline-offset: 3px;
    }

    /* DESKTOP */
    @media (min-width: 992px) {
        .food-profile-page .profile-layout>.col-lg-4 .food-profile-card {
            padding: 27px 23px;
        }
    }

    /* TABLET & MOBILE */
    @media (max-width: 767px) {
        .food-profile-page {
            padding: 30px 0 45px;
        }

        .food-profile-page .profile-heading {
            padding: 27px 22px;
            margin-bottom: 22px;
            border-radius: 19px;
        }

        .food-profile-page .profile-heading .eyebrow {
            font-size: 11px;
        }

        .food-profile-page .profile-heading h2 {
            font-size: 29px;
            letter-spacing: -.7px;
        }

        .food-profile-page .profile-heading p {
            font-size: 13px;
            line-height: 1.8;
        }

        .food-profile-page .food-profile-card {
            height: auto;
            padding: 20px;
            margin-bottom: 18px;
            border-radius: 16px;
        }

        .food-profile-page .profile-user-box {
            gap: 14px;
            padding: 17px;
            margin-bottom: 26px;
        }

        .food-profile-page .profile-avatar {
            width: 59px;
            height: 59px;
            border-radius: 17px;
            font-size: 23px;
        }

        .food-profile-page .profile-user-name {
            font-size: 19px;
        }

        .food-profile-page .profile-user-email {
            font-size: 13px;
        }

        .food-profile-page .profile-card-heading {
            gap: 12px;
            margin-bottom: 24px;
        }

        .food-profile-page .heading-icon {
            width: 45px;
            height: 45px;
            border-radius: 13px;
            font-size: 19px;
        }

        .food-profile-page .profile-card-heading h4 {
            font-size: 18px;
        }

        .food-profile-page .section-subtitle {
            font-size: 13px;
        }

        .food-profile-page .form-label {
            font-size: 13px;
        }

        .food-profile-page .form-control {
            min-height: 49px;
            padding: 12px 13px;
            font-size: 14px;
        }

        .food-profile-page .food-btn {
            min-height: 47px;
            padding: 11px 16px;
            font-size: 14px;
        }

        .food-profile-page .profile-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .food-profile-page .profile-actions .food-btn {
            width: 100%;
        }

        .food-profile-page .profile-side-link {
            padding: 14px 12px;
        }

        .food-profile-page .side-link-text strong {
            font-size: 14px;
        }

        .food-profile-page .side-link-text small {
            font-size: 12px;
        }

        .food-profile-page .profile-help-box {
            padding: 15px;
            font-size: 13px;
        }

        .food-profile-page::before {
            width: 200px;
            height: 200px;
        }

        .food-profile-page::after {
            width: 170px;
            height: 170px;
        }
    }

    /* SMALL PHONES */
    @media (max-width: 380px) {
        .food-profile-page .profile-heading {
            padding: 23px 17px;
        }

        .food-profile-page .profile-heading h2 {
            font-size: 25px;
        }

        .food-profile-page .food-profile-card {
            padding: 16px;
        }

        .food-profile-page .profile-user-box {
            gap: 11px;
            padding: 13px;
        }

        .food-profile-page .profile-avatar {
            width: 52px;
            height: 52px;
            font-size: 21px;
        }
    }

    /* REDUCED MOTION */
    @media (prefers-reduced-motion: reduce) {

        .food-profile-page *,
        .food-profile-page *::before,
        .food-profile-page *::after {
            animation: none !important;
            transition: none !important;
            scroll-behavior: auto !important;
        }
    }
</style>

<section class="food-profile-page">
    <div class="container">

        <div class="profile-heading">
            <div class="eyebrow">Your Account</div>
            <h2>My Profile</h2>
            <p>Manage your personal information and delivery preferences.</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="row g-4 profile-layout">

            {{-- Personal Information --}}
            <div class="col-lg-8">
                <div class="food-profile-card">

                    <div class="profile-user-box">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="profile-user-info">
                            <div class="profile-user-name">
                                {{ $user->name }}
                            </div>

                            <div class="profile-user-email">
                                {{ $user->email }}
                            </div>

                            <span class="profile-status">
                                <i class="fas fa-shield-alt"></i>
                                Account Information
                            </span>
                        </div>
                    </div>

                    <div class="profile-card-heading">
                        <div class="heading-icon">
                            <i class="fas fa-user-edit"></i>
                        </div>

                        <div>
                            <h4>Personal Information</h4>
                            <p class="section-subtitle">
                                Update your details and save changes to your account.
                            </p>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Full Name <span class="text-danger">*</span>
                                </label>

                                <input type="text" id="name" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}" placeholder="Enter your full name"
                                    maxlength="255" autocomplete="name" required>

                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>

                                <input type="email" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}" placeholder="Enter your email address"
                                    maxlength="255" autocomplete="email" required>

                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="mobile" class="form-label">
                                    Mobile Number
                                </label>

                                <input type="tel" id="mobile" name="mobile"
                                    class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $user->mobile ?? '') }}"
                                    placeholder="Enter your mobile number" maxlength="20" autocomplete="tel">

                                <div class="field-hint">
                                    Make sure your mobile number is correct.
                                </div>

                                @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="profile-help-box">
                            <i class="fas fa-info-circle"></i>
                            Click Save Changes to submit your updated profile details.
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4 profile-actions">
                            <button type="submit" class="food-btn">
                                <i class="fas fa-save"></i>
                                Save Changes
                            </button>

                            <a href="{{ route('site.products') }}" class="food-btn food-btn-outline">
                                <i class="fas fa-utensils"></i>
                                Continue Shopping
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            {{-- Account Links --}}
            <div class="col-lg-4">
                <div class="food-profile-card">

                    <div class="profile-card-heading">
                        <div class="heading-icon">
                            <i class="fas fa-th-large"></i>
                        </div>

                        <div>
                            <h4>My Account</h4>
                            <p class="section-subtitle">
                                Quick access to your account.
                            </p>
                        </div>
                    </div>

                    <a href="{{ route('addresses.index') }}" class="profile-side-link">
                        <div class="side-link-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>

                        <div class="side-link-text">
                            <strong>My Addresses</strong>
                            <small>Add, edit and manage delivery addresses</small>
                        </div>

                        <i class="fas fa-chevron-right side-link-arrow"></i>
                    </a>

                    <a href="{{ route('site.products') }}" class="profile-side-link">
                        <div class="side-link-icon">
                            <i class="fas fa-utensils"></i>
                        </div>

                        <div class="side-link-text">
                            <strong>Browse Products</strong>
                            <small>Explore our food menu</small>
                        </div>

                        <i class="fas fa-chevron-right side-link-arrow"></i>
                    </a>

                    <a href="{{ route('cart') }}" class="profile-side-link">
                        <div class="side-link-icon">
                            <i class="fas fa-shopping-basket"></i>
                        </div>

                        <div class="side-link-text">
                            <strong>My Cart</strong>
                            <small>View your shopping cart</small>
                        </div>

                        <i class="fas fa-chevron-right side-link-arrow"></i>
                    </a>
                    
                    {{-- My Orders --}}
                    <a href="{{ route('orders.my') }}" class="profile-side-link">
                        <div class="side-link-icon">
                            <i class="fas fa-receipt"></i>
                        </div>

                        <div class="side-link-text">
                            <strong>My Orders</strong>
                            <small>View previous orders and track order status</small>
                        </div>

                        <i class="fas fa-chevron-right side-link-arrow"></i>
                    </a>
                    <div class="profile-help-box">
                        <i class="fas fa-lock"></i>
                        Your account details can be updated from the form on this page.
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection