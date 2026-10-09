{{-- LOGIN POPUP --}}

<div class="modal fade food-login-modal" id="loginModal" tabindex="-1"
    aria-labelledby="loginModalLabel" aria-hidden="true">

<div class="modal-dialog modal-dialog-centered">

    <div class="modal-content food-login-content">

        {{-- CLOSE --}}
        <button type="button"
            class="food-login-close"
            data-bs-dismiss="modal"
            aria-label="Close">
            <i class="fal fa-times"></i>
        </button>

        <div class="row g-0">

            {{-- LEFT SIDE --}}
            <div class="col-lg-5 d-none d-lg-block">

                <div class="login-food-side">

                    <div class="login-food-overlay"></div>

                    <div class="login-food-content">

                        <div class="login-brand-icon">
                            <i class="far fa-utensils"></i>
                        </div>

                        <h2>
                            Welcome<br>
                            Back!
                        </h2>

                        <p>
                            Delicious food is just a login away.
                        </p>

                        <div class="login-food-line"></div>
                        {{-- <span>
                            Fresh • Tasty • Made With Love
                        </span> --}}

                    </div>

                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="col-lg-7">

                <div class="login-form-area">

                    {{-- HEADER --}}
                    <div class="login-header">

                        <span class="login-small-title">
                            Welcome Back
                        </span>

                        <h3 id="loginModalLabel">
                            Login to your account
                        </h3>

                        <p>
                            Enter your details and continue your food journey.
                        </p>

                    </div>


                    {{-- FORM --}}
                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        {{-- EMAIL --}}
                        <div class="food-login-field">

                            <label for="loginEmail">
                                Email Address
                            </label>

                            <div class="food-input-box">

                                <i class="far fa-envelope"></i>

                                <input
                                    type="email"
                                    id="loginEmail"
                                    name="email"
                                    placeholder="Enter your email"
                                    value="{{ old('email') }}"
                                    autocomplete="email"
                                    required
                                >

                            </div>

                            @error('email')
                                <small class="text-danger login-field-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- PASSWORD --}}
                        <div class="food-login-field">

                            <label for="loginPassword">
                                Password
                            </label>

                            <div class="food-input-box">

                                <i class="far fa-lock"></i>

                                <input
                                    type="password"
                                    id="loginPassword"
                                    name="password"
                                    placeholder="Enter your password"
                                    autocomplete="current-password"
                                    required
                                >

                                {{-- SHOW / HIDE PASSWORD --}}
                                <button
                                    type="button"
                                    class="password-toggle"
                                    id="loginPasswordToggle"
                                    aria-label="Show password"
                                >
                                    <i class="far fa-eye"></i>
                                </button>

                            </div>

                            @error('password')
                                <small class="text-danger login-field-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- OPTIONS --}}
                        <div class="food-login-options">

                            <label class="food-remember">

                                {{-- <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                >

                                <span>Remember me</span> --}}

                            </label>

                            <a href="javascript:void(0);">
                                Forgot Password?
                            </a>

                        </div>


                        {{-- BUTTON --}}
                        <button type="submit" class="food-login-btn">

                            <span>Login</span>

                            <i class="far fa-arrow-right"></i>

                        </button>

                    </form>


                    {{-- REGISTER --}}
                    <div class="food-register">

                        <span>
                            Don't have an account?
                        </span>

                        <a
                            href="javascript:void(0);"
                            data-bs-dismiss="modal"
                            data-bs-toggle="modal"
                            data-bs-target="#registerModal"
                        >
                            Create Account
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
```

</div>

<style>

/* =====================================================
   FOOD LOGIN MODAL
===================================================== */

.food-login-modal .modal-dialog {
    max-width: 780px;
}

.food-login-content {
    border: 0;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
    position: relative;
}


/* =====================================================
   CLOSE BUTTON
===================================================== */

.food-login-close {
    position: absolute;
    right: 18px;
    top: 18px;

    width: 36px;
    height: 36px;

    border: 0;
    border-radius: 50%;

    background: rgba(255, 255, 255, 0.95);
    color: #222;

    display: flex;
    align-items: center;
    justify-content: center;

    z-index: 20;
    cursor: pointer;

    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.10);

    transition: all .3s ease;
}

.food-login-close:hover {
    background: #e53935;
    color: #fff;
    transform: rotate(90deg);
}


/* =====================================================
   LEFT FOOD SECTION
===================================================== */

.login-food-side {
    height: 100%;
    min-height: 500px;

    position: relative;

    background-image: url("{{ asset('assets/img/food/delicious-burger.png') }}");

    background-repeat: no-repeat;
    background-position: center 72%;
    background-size: 250px;

    background-color: #ffb300;

    overflow: hidden;
}

.login-food-side::before {
    content: "";
    position: absolute;

    width: 330px;
    height: 330px;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.15);

    top: -100px;
    left: -100px;
}

.login-food-side::after {
    content: "";
    position: absolute;

    width: 260px;
    height: 260px;

    border-radius: 50%;

    border: 35px solid rgba(229, 57, 53, 0.15);

    bottom: -90px;
    right: -80px;
}

.login-food-overlay {
    position: absolute;
    inset: 0;

    background: linear-gradient(
        to bottom,
        rgba(255, 193, 7, 0.08),
        rgba(229, 57, 53, 0.20)
    );
}

.login-food-content {
    position: relative;
    z-index: 5;

    padding: 45px 35px;

    color: #fff;
}

.login-brand-icon {
    width: 55px;
    height: 55px;

    border-radius: 50%;

    background: #fff;
    color: #e53935;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 22px;

    margin-bottom: 25px;
}

.login-food-content h2 {
    color: #fff;

    font-size: 42px;
    line-height: 1.05;

    margin-bottom: 15px;
}

.login-food-content p {
    color: rgba(255, 255, 255, 0.92);

    font-size: 15px;
    line-height: 1.7;

    max-width: 220px;
}

.login-food-line {
    width: 45px;
    height: 3px;

    background: #fff8dc;

    margin: 25px 0 12px;
}

.login-food-content span {
    font-size: 11px;
    font-weight: 600;

    letter-spacing: 1px;

    text-transform: uppercase;

    color: #fff8dc;
}


/* =====================================================
   RIGHT FORM
===================================================== */

.login-form-area {
    padding: 48px 45px 40px;
}

.login-header {
    margin-bottom: 27px;
}

.login-small-title {
    color: #e53935;

    font-size: 12px;
    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 1px;
}

.login-header h3 {
    font-size: 28px;

    line-height: 1.2;

    margin: 7px 0 8px;
}

.login-header p {
    font-size: 13px;

    color: #777;

    margin: 0;
}


/* =====================================================
   INPUT
===================================================== */

.food-login-field {
    margin-bottom: 17px;
}

.food-login-field label {
    display: block;

    font-size: 13px;
    font-weight: 600;

    margin-bottom: 7px;

    color: #222;
}

.food-input-box {
    height: 49px;

    border: 1px solid #e5e5e5;

    border-radius: 8px;

    display: flex;
    align-items: center;

    padding: 0 14px;

    background: #fff;

    transition: all .3s ease;
}

.food-input-box:hover {
    border-color: #f0c36d;
}

.food-input-box:focus-within {
    border-color: #e53935;

    box-shadow:
        0 0 0 3px rgba(229, 57, 53, 0.08);
}

.food-input-box > i:first-child {
    color: #999;

    font-size: 14px;

    margin-right: 10px;

    transition: color .3s ease;
}

.food-input-box:focus-within > i:first-child {
    color: #e53935;
}

.food-input-box input {
    width: 100%;

    border: 0;
    outline: 0;

    background: transparent;

    font-size: 13px;

    color: #222;

    min-width: 0;
}


/* =====================================================
   PASSWORD SHOW / HIDE
===================================================== */

.password-toggle {
    width: 32px;
    height: 32px;

    flex: 0 0 32px;

    border: 0;
    background: transparent;

    color: #999;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    padding: 0;
    margin-left: 5px;

    transition: all .2s ease;
}

.password-toggle:hover {
    color: #e53935;
}

.password-toggle:focus {
    outline: none;
    color: #e53935;
}


/* =====================================================
   FIELD ERROR
===================================================== */

.login-field-error {
    display: block;

    margin-top: 5px;

    font-size: 11px;
}


/* =====================================================
   OPTIONS
===================================================== */

.food-login-options {
    display: flex;

    align-items: center;
    justify-content: space-between;

    margin: 5px 0 20px;

    font-size: 12px;
}

.food-remember {
    display: flex !important;

    align-items: center;

    gap: 6px;

    margin: 0 !important;
}

.food-remember input {
    margin: 0;

    accent-color: #e53935;
}

.food-login-options a {
    color: #e53935;

    font-weight: 600;
}

.food-login-options a:hover {
    color: #c62828;
}


/* =====================================================
   LOGIN BUTTON
===================================================== */

.food-login-btn {
    width: 100%;
    height: 50px;

    border: 0;
    border-radius: 8px;

    background: linear-gradient(
        135deg,
        #e53935,
        #c62828
    );

    color: #fff;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 10px;

    font-size: 14px;
    font-weight: 600;

    cursor: pointer;

    box-shadow:
        0 8px 20px rgba(229, 57, 53, .18);

    transition: all .3s ease;
}

.food-login-btn i {
    transition: transform .3s ease;
}

.food-login-btn:hover {
    background: linear-gradient(
        135deg,
        #c62828,
        #b71c1c
    );

    color: #fff;

    transform: translateY(-2px);

    box-shadow:
        0 12px 25px rgba(229, 57, 53, .25);
}

.food-login-btn:hover i {
    transform: translateX(5px);
}


/* =====================================================
   REGISTER
===================================================== */

.food-register {
    text-align: center;

    margin-top: 22px;
    padding-top: 18px;

    border-top: 1px solid #eeeeee;

    font-size: 13px;

    color: #777;
}

.food-register a {
    color: #e53935;

    font-weight: 600;

    margin-left: 4px;
}

.food-register a:hover {
    color: #c62828;
}


/* =====================================================
   SWEET ALERT
===================================================== */

.food-login-swal-popup {
    border-radius: 18px !important;
    padding: 25px !important;
}

.food-login-swal-button {
    min-width: 110px;

    border-radius: 8px !important;

    font-weight: 700 !important;
}


/* =====================================================
   MOBILE
===================================================== */

@media (max-width: 767px) {

    .food-login-modal .modal-dialog {
        max-width: calc(100% - 25px);
        margin: 12px auto;
    }

    .login-form-area {
        padding: 40px 25px 30px;
    }

    .login-header h3 {
        font-size: 25px;
    }

}

@media (max-width: 400px) {

    .login-form-area {
        padding: 35px 20px 25px;
    }

    .food-login-options {
        flex-wrap: wrap;
        gap: 8px;
    }

}

</style>

{{-- =====================================================
LOGIN SWEETALERT + PASSWORD TOGGLE
===================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =================================================
       PASSWORD SHOW / HIDE
    ================================================= */

    const passwordInput = document.getElementById('loginPassword');
    const passwordToggle = document.getElementById('loginPasswordToggle');

    if (passwordInput && passwordToggle) {

        passwordToggle.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                passwordToggle.innerHTML =
                    '<i class="far fa-eye-slash"></i>';

                passwordToggle.setAttribute(
                    'aria-label',
                    'Hide password'
                );

            } else {

                passwordInput.type = 'password';

                passwordToggle.innerHTML =
                    '<i class="far fa-eye"></i>';

                passwordToggle.setAttribute(
                    'aria-label',
                    'Show password'
                );

            }

        });

    }


    /* =================================================
       LOGIN SUCCESS
    ================================================= */

    @if (session('login_success'))

        Swal.fire({
            icon: 'success',
            title: 'Login Successful!',
            text: @json(session('login_success')),
            confirmButtonText: 'Continue',
            confirmButtonColor: '#e53935',
            background: '#ffffff',
            color: '#222',
            customClass: {
                popup: 'food-login-swal-popup',
                confirmButton: 'food-login-swal-button'
            }
        });

    @endif


    /* =================================================
       LOGIN ERROR
    ================================================= */

    @if ($errors->any())

        const loginErrors = @json($errors->all());

        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            html: loginErrors
                .map(function (error) {
                    return '<div style="margin-bottom:5px;">' +
                        error +
                        '</div>';
                })
                .join(''),
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#e53935',
            background: '#ffffff',
            color: '#222',
            customClass: {
                popup: 'food-login-swal-popup',
                confirmButton: 'food-login-swal-button'
            }
        }).then(function () {

            const loginModalElement =
                document.getElementById('loginModal');

            if (loginModalElement) {

                const loginModal =
                    bootstrap.Modal.getOrCreateInstance(
                        loginModalElement
                    );

                loginModal.show();
            }

        });

    @endif

});

</script>
