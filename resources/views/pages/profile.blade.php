@extends('layouts.site-layout')

@section('title', 'My Profile | Food Website')

@section('meta_description', 'Manage your profile and saved addresses.')

@section('content')
<style>
/* Uses your website variables (--theme, --theme3, --bg ...) with safe fallbacks */
.food-profile-page{--g:var(--theme,#00813d);--gd:#006a32;--gl:#2fb36b;--y:var(--theme3,#ffb936);--dark:var(--header,#212121);--txt:var(--text,#5c5c5b);--ln:var(--border,#d9d9d9);--cream:var(--bg,#f4f1ea);--soft:#e6f4ec;--sh:0 10px 32px rgba(33,33,33,.07);position:relative;isolation:isolate;overflow:hidden;min-height:75vh;padding:55px 0 75px;background:radial-gradient(ellipse at 5% 10%,rgba(0,129,61,.1),transparent 32%),radial-gradient(ellipse at 95% 45%,rgba(255,185,54,.12),transparent 34%),var(--cream);color:var(--dark)}
.food-profile-page *,.food-profile-page *::before,.food-profile-page *::after{box-sizing:border-box}
.food-profile-page .container{position:relative;z-index:1}

/* floating background rings */
.food-profile-page::before,.food-profile-page::after{content:"";position:absolute;z-index:-1;pointer-events:none;border-radius:50%}
.food-profile-page::before{width:300px;height:300px;top:220px;left:-220px;border:50px solid rgba(0,129,61,.07);animation:profile-orbit 16s ease-in-out infinite alternate}
.food-profile-page::after{width:250px;height:250px;right:-180px;bottom:45px;border:42px solid rgba(255,185,54,.14);animation:profile-orbit 13s ease-in-out infinite alternate-reverse}
@keyframes profile-orbit{to{transform:translate3d(18px,-22px,0) rotate(30deg)}}
@keyframes profile-enter{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:none}}
@keyframes profile-glow{0%,100%{box-shadow:0 0 0 4px rgba(0,129,61,.1),0 8px 24px rgba(0,129,61,.2)}50%{box-shadow:0 0 0 8px rgba(0,129,61,.07),0 8px 30px rgba(0,129,61,.28)}}

/* ---------- Hero ---------- */
.food-profile-page .profile-heading{position:relative;overflow:hidden;isolation:isolate;padding:38px 36px;margin-bottom:30px;border-radius:24px;background:radial-gradient(circle at 90% 5%,rgba(255,185,54,.28),transparent 35%),linear-gradient(115deg,#003d1c 0%,var(--g) 58%,var(--gl) 100%);box-shadow:0 17px 40px rgba(0,129,61,.22);animation:profile-enter .6s ease both}
.food-profile-page .profile-heading::before{content:"";position:absolute;z-index:-1;width:290px;height:290px;top:-205px;right:-30px;border:45px solid rgba(255,255,255,.1);border-radius:50%;box-shadow:0 0 0 30px rgba(255,255,255,.035)}
.food-profile-page .profile-heading::after{content:"";position:absolute;z-index:-1;width:90px;height:90px;right:19%;bottom:-65px;border-radius:25px;background:rgba(255,185,54,.18);transform:rotate(35deg)}
.food-profile-page .profile-heading .eyebrow{display:inline-flex;align-items:center;gap:9px;margin-bottom:14px;color:var(--y);font-size:13px;font-weight:800;letter-spacing:2.5px;text-transform:uppercase}
.food-profile-page .profile-heading .eyebrow::before{content:"";width:25px;height:3px;border-radius:5px;background:var(--y)}
.food-profile-page .profile-heading h2{margin:0 0 12px;color:#fff;font-size:clamp(30px,4vw,42px);font-weight:800;line-height:1.25;letter-spacing:-1px}
.food-profile-page .profile-heading p{max-width:580px;margin:0;color:rgba(255,255,255,.9);font-size:15px;line-height:1.9}

/* ---------- Cards ---------- */
.food-profile-page .profile-layout{align-items:stretch}
.food-profile-page .food-profile-card{position:relative;height:100%;padding:29px;margin-bottom:24px;overflow:hidden;background:#fff;border-radius:22px;box-shadow:var(--sh);animation:profile-enter .65s ease both;transition:box-shadow .3s,transform .3s}
.food-profile-page .profile-layout>div:first-child .food-profile-card{animation-delay:.08s}
.food-profile-page .profile-layout>div:last-child .food-profile-card{animation-delay:.17s}
.food-profile-page .food-profile-card:hover{box-shadow:0 16px 40px rgba(33,33,33,.11)}

/* ---------- User panel ---------- */
.food-profile-page .profile-user-box{position:relative;display:flex;align-items:center;gap:20px;min-width:0;padding:26px;margin-bottom:34px;overflow:hidden;border:1px solid #d3eadc;border-radius:20px;background:radial-gradient(circle at 100% 0%,rgba(0,129,61,.12),transparent 38%),linear-gradient(120deg,#eef8f2,#fafdfb)}
.food-profile-page .profile-user-box::after{content:"";position:absolute;width:125px;height:125px;right:-65px;top:-63px;border:23px solid rgba(0,129,61,.09);border-radius:50%;pointer-events:none}
.food-profile-page .profile-avatar{position:relative;display:flex;align-items:center;justify-content:center;flex-shrink:0;width:76px;height:76px;border:3px solid rgba(255,255,255,.9);border-radius:23px;background:linear-gradient(140deg,var(--gl),var(--g) 55%,var(--gd));color:#fff;font-size:29px;animation:profile-glow 4s ease-in-out infinite;transition:border-radius .3s,transform .3s}
.food-profile-page .profile-user-box:hover .profile-avatar{border-radius:50%;transform:rotate(-5deg)}
.food-profile-page .profile-user-info{position:relative;z-index:1;min-width:0}
.food-profile-page .profile-user-name{margin-bottom:6px;color:var(--dark);font-size:24px;font-weight:800;line-height:1.4;letter-spacing:-.5px;overflow-wrap:anywhere}
.food-profile-page .profile-user-email{color:var(--txt);font-size:15px;line-height:1.7;overflow-wrap:anywhere}
.food-profile-page .profile-status{display:inline-flex;align-items:center;gap:8px;padding:6px 14px;margin-top:12px;border-radius:99px;background:var(--soft);color:var(--g);font-size:12px;font-weight:700}

/* ---------- Section headings ---------- */
.food-profile-page .profile-card-heading{display:flex;align-items:flex-start;gap:16px;margin-bottom:30px}
.food-profile-page .heading-icon{display:flex;align-items:center;justify-content:center;flex-shrink:0;width:54px;height:54px;border-radius:16px;background:linear-gradient(145deg,var(--soft),#cfe8d9);color:var(--g);font-size:22px;transition:transform .3s,border-radius .3s}
.food-profile-page .profile-card-heading:hover .heading-icon{transform:rotate(-7deg) scale(1.06);border-radius:12px}
.food-profile-page .profile-card-heading h4{margin:2px 0 7px;color:var(--dark);font-size:21px;font-weight:800;line-height:1.45;letter-spacing:-.45px}
.food-profile-page .section-subtitle{margin:0;color:var(--txt);font-size:14px;line-height:1.8}

/* ---------- Form ---------- */
.food-profile-page .form-label{display:inline-block;margin-bottom:9px;color:var(--dark);font-size:13px;font-weight:700}
.food-profile-page .form-control{display:block;width:100%;min-height:54px;padding:14px 16px;background:#fff;border:1px solid var(--ln);border-radius:12px;box-shadow:none;color:var(--dark);font-size:14px;transition:background .25s,border-color .25s,box-shadow .25s}
.food-profile-page .form-control::placeholder{color:#a3a3a0;opacity:1}
.food-profile-page .form-control:hover{border-color:#8fcaa8}
.food-profile-page .form-control:focus{border-color:var(--g);outline:none;box-shadow:0 0 0 4px rgba(0,129,61,.12)}
.food-profile-page .form-control.is-invalid{border-color:#dc3545}
.food-profile-page .form-control.is-invalid:focus{box-shadow:0 0 0 4px rgba(220,53,69,.1)}
.food-profile-page .invalid-feedback{display:block;margin-top:8px;font-size:13px}
.food-profile-page .field-hint{margin-top:8px;color:#8a8a86;font-size:12px;line-height:1.8}

/* ---------- Buttons (with the shine sweep) ---------- */
.food-profile-page .food-btn{position:relative;display:inline-flex;align-items:center;justify-content:center;gap:9px;min-height:50px;padding:12px 24px;overflow:hidden;border:1px solid transparent;border-radius:12px;background:linear-gradient(110deg,var(--g),var(--gl));color:#fff;font-size:14px;font-weight:700;text-decoration:none;text-align:center;white-space:nowrap;cursor:pointer;box-shadow:0 8px 20px rgba(0,129,61,.25);transition:transform .25s,box-shadow .25s,background .25s}
.food-profile-page .food-btn::before{content:"";position:absolute;top:-40%;left:-65%;width:38%;height:180%;background:rgba(255,255,255,.28);transform:rotate(22deg);transition:left .55s;pointer-events:none}
.food-profile-page .food-btn:hover::before{left:130%}
.food-profile-page .food-btn:hover{transform:translateY(-2px);box-shadow:0 12px 26px rgba(0,129,61,.32);color:#fff}
.food-profile-page .food-btn:active{transform:scale(.98)}
.food-profile-page .food-btn-outline{background:#fff;border-color:var(--ln);color:var(--dark);box-shadow:none}
.food-profile-page .food-btn-outline:hover{background:#fff;border-color:var(--g);color:var(--g);box-shadow:0 8px 18px rgba(0,129,61,.12)}
.food-profile-page .profile-actions{display:flex;flex-wrap:wrap;align-items:center;gap:10px}

/* ---------- Info box ---------- */
.food-profile-page .profile-help-box{padding:18px 19px;margin-top:26px;border:1px dashed #b9dbc6;border-radius:14px;background:#f4faf6;color:var(--txt);font-size:14px;line-height:1.9}
.food-profile-page .profile-help-box i{margin-right:7px;color:var(--g)}

/* ---------- Sidebar links ---------- */
.food-profile-page .profile-side-link{position:relative;display:flex;align-items:center;gap:15px;min-width:0;padding:16px 14px;margin-top:14px;overflow:hidden;background:#fff;border:1px solid #ece8de;border-radius:16px;color:var(--dark);text-decoration:none;transition:transform .25s,border-color .25s,box-shadow .25s,background .25s}
.food-profile-page .profile-side-link::before{content:"";position:absolute;top:15%;bottom:15%;left:0;width:4px;border-radius:0 5px 5px 0;background:linear-gradient(var(--gl),var(--g));transform:scaleY(0);transition:transform .25s}
.food-profile-page .profile-side-link:hover{transform:translateX(3px);border-color:#b9dbc6;background:linear-gradient(105deg,#fafdfb,#eef8f2);box-shadow:0 8px 20px rgba(33,33,33,.07);color:var(--dark)}
.food-profile-page .profile-side-link:hover::before{transform:scaleY(1)}
.food-profile-page .side-link-icon{display:flex;align-items:center;justify-content:center;flex-shrink:0;width:49px;height:49px;border-radius:14px;background:var(--soft);color:var(--g);font-size:19px;transition:transform .3s,background .3s,color .3s}
.food-profile-page .profile-side-link:hover .side-link-icon{transform:rotate(-6deg) scale(1.07);background:linear-gradient(140deg,var(--gl),var(--g));color:#fff}
.food-profile-page .side-link-text{flex:1;min-width:0}
.food-profile-page .side-link-text strong{display:block;margin-bottom:5px;color:inherit;font-size:15px;font-weight:700;line-height:1.5}
.food-profile-page .side-link-text small{display:block;color:var(--txt);font-size:12px;line-height:1.75}
.food-profile-page .side-link-arrow{flex-shrink:0;color:#b5b5b0;font-size:14px;transition:transform .25s,color .25s}
.food-profile-page .profile-side-link:hover .side-link-arrow{transform:translateX(4px);color:var(--g)}

/* ---------- Alerts ---------- */
.food-profile-page .alert{border:0;border-radius:14px;font-size:14px;line-height:1.8;animation:profile-enter .4s ease both}
.food-profile-page .alert-success{background:var(--soft);color:#00642f}
.food-profile-page .alert ul{padding-left:22px}

/* ---------- Accessibility ---------- */
.food-profile-page a:focus-visible,.food-profile-page button:focus-visible{outline:3px solid rgba(0,129,61,.4);outline-offset:3px}

@media(min-width:992px){.food-profile-page .profile-layout>.col-lg-4 .food-profile-card{padding:27px 23px}}

/* ---------- Tablet & mobile ---------- */
@media(max-width:767px){
    .food-profile-page{padding:30px 0 45px}
    .food-profile-page::before{width:200px;height:200px}
    .food-profile-page::after{width:170px;height:170px}
    .food-profile-page .profile-heading{padding:27px 22px;margin-bottom:22px;border-radius:19px}
    .food-profile-page .profile-heading .eyebrow{font-size:11px}
    .food-profile-page .profile-heading h2{font-size:29px}
    .food-profile-page .profile-heading p{font-size:13px;line-height:1.8}
    .food-profile-page .food-profile-card{height:auto;padding:20px;margin-bottom:18px;border-radius:18px}
    .food-profile-page .profile-user-box{gap:14px;padding:17px;margin-bottom:26px}
    .food-profile-page .profile-avatar{width:59px;height:59px;border-radius:17px;font-size:23px}
    .food-profile-page .profile-user-name{font-size:19px}
    .food-profile-page .profile-user-email{font-size:13px}
    .food-profile-page .profile-card-heading{gap:12px;margin-bottom:24px}
    .food-profile-page .heading-icon{width:45px;height:45px;border-radius:13px;font-size:19px}
    .food-profile-page .profile-card-heading h4{font-size:18px}
    .food-profile-page .section-subtitle{font-size:13px}
    .food-profile-page .form-control{min-height:50px;padding:12px 13px}
    .food-profile-page .profile-actions{flex-direction:column;align-items:stretch}
    .food-profile-page .profile-actions .food-btn{width:100%}
    .food-profile-page .profile-side-link{padding:14px 12px}
    .food-profile-page .side-link-text strong{font-size:14px}
    .food-profile-page .profile-help-box{padding:15px;font-size:13px}
}
@media(max-width:380px){
    .food-profile-page .profile-heading{padding:23px 17px}
    .food-profile-page .profile-heading h2{font-size:25px}
    .food-profile-page .food-profile-card{padding:16px}
    .food-profile-page .profile-user-box{gap:11px;padding:13px}
    .food-profile-page .profile-avatar{width:52px;height:52px;font-size:21px}
}
@media(prefers-reduced-motion:reduce){
    .food-profile-page *,.food-profile-page *::before,.food-profile-page *::after{animation:none!important;transition:none!important;scroll-behavior:auto!important}
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