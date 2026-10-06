```blade
{{-- REGISTER POPUP --}}

<div class="modal fade food-register-modal"
    id="registerModal"
    tabindex="-1"
    aria-labelledby="registerModalLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content food-register-popup">

            {{-- TOP HEADER --}}
            <div class="register-hero">

                <div class="register-hero-circle circle-one"></div>
                <div class="register-hero-circle circle-two"></div>

                <button type="button"
                    class="register-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">

                    <i class="fal fa-times"></i>

                </button>

                <div class="register-hero-content">

                    <div class="register-icon">
                        <i class="far fa-user-plus"></i>
                    </div>

                    <div>

                        <span class="register-eyebrow">
                            Welcome To Our Kitchen
                        </span>

                        <h3 id="registerModalLabel">
                            Create Your Account
                        </h3>

                    </div>

                </div>

            </div>


            {{-- BODY --}}
            <div class="register-body">

                <div class="register-intro">

                    <p>
                        Create your account and enjoy delicious food,
                        exclusive combos and special offers.
                    </p>

                </div>


                {{-- REGISTER FORM --}}
                <form action="{{ route('register.submit') }}"
                    method="POST">

                    @csrf


                    {{-- NAME --}}
                    <div class="register-field">

                        <label for="registerName">
                            Full Name
                        </label>

                        <div class="register-input">

                            <span class="register-input-icon">
                                <i class="far fa-user"></i>
                            </span>

                            <input type="text"
                                id="registerName"
                                name="name"
                                placeholder="Enter your full name"
                                value="{{ old('name') }}"
                                autocomplete="name"
                                required>

                        </div>

                    </div>


                    {{-- EMAIL --}}
                    <div class="register-field">

                        <label for="registerEmail">
                            Email Address
                        </label>

                        <div class="register-input">

                            <span class="register-input-icon">
                                <i class="far fa-envelope"></i>
                            </span>

                            <input type="email"
                                id="registerEmail"
                                name="email"
                                placeholder="Enter your email address"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required>

                        </div>

                    </div>


                    {{-- PASSWORD --}}
                    <div class="register-field">

                        <label for="registerPassword">
                            Password
                        </label>

                        <div class="register-input">

                            <span class="register-input-icon">
                                <i class="far fa-lock"></i>
                            </span>

                            <input type="password"
                                id="registerPassword"
                                name="password"
                                placeholder="Create a password"
                                autocomplete="new-password"
                                required>

                        </div>

                    </div>


                    {{-- CONFIRM PASSWORD --}}
                    <div class="register-field">

                        <label for="registerPasswordConfirmation">
                            Confirm Password
                        </label>

                        <div class="register-input">

                            <span class="register-input-icon">
                                <i class="far fa-lock"></i>
                            </span>

                            <input type="password"
                                id="registerPasswordConfirmation"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                autocomplete="new-password"
                                required>

                        </div>

                    </div>


                    {{-- TERMS --}}
                    <div class="register-terms">

                        <span class="terms-check">
                            <i class="far fa-check"></i>
                        </span>

                        <p>
                            By creating an account, you agree to our
                            <a href="#">
                                Terms & Conditions
                            </a>.
                        </p>

                    </div>


                    {{-- BUTTON --}}
                    <button type="submit"
                        class="register-btn">

                        <span>
                            Create Account
                        </span>

                        <span class="register-btn-icon">
                            <i class="far fa-arrow-right"></i>
                        </span>

                    </button>

                </form>


                {{-- LOGIN --}}
                <div class="register-login-link">

                    <span>
                        Already have an account?
                    </span>

                    <a href="javascript:void(0);"
                        data-bs-dismiss="modal"
                        data-bs-toggle="modal"
                        data-bs-target="#loginModal">

                        Login Now

                    </a>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

/* =========================================================
   REGISTER MODAL - MAIN
========================================================= */

#registerModal .modal-dialog {
    width: 100%;
    max-width: 510px;
    margin: 1.75rem auto;
    padding: 12px;
}

.food-register-popup {
    position: relative;
    width: 100%;
    border: 0;
    border-radius: 22px;
    overflow: hidden;
    background: #ffffff;
    box-shadow: 0 30px 80px rgba(0, 0, 0, .25);
    color: #222;
}


/* =========================================================
   TOP HERO
========================================================= */

.register-hero {
    position: relative;
    min-height: 138px;
    overflow: hidden;

    background: linear-gradient(
        135deg,
        #ffd54f 0%,
        #ffb300 55%,
        #e53935 100%
    );

    color: #fff;
}


/* =========================================================
   DECORATIVE CIRCLES
========================================================= */

.register-hero-circle {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, .18);
    pointer-events: none;
}

.circle-one {
    width: 190px;
    height: 190px;
    top: -105px;
    right: -35px;
}

.circle-two {
    width: 115px;
    height: 115px;
    bottom: -75px;
    left: 30px;
}


/* =========================================================
   HERO CONTENT
========================================================= */

.register-hero-content {
    position: relative;
    z-index: 3;

    min-height: 138px;
    padding: 30px 55px 28px 34px;

    display: flex;
    align-items: center;
    gap: 17px;
}


/* =========================================================
   ICON
========================================================= */

.register-icon {
    flex: 0 0 auto;

    width: 62px;
    height: 62px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;
    background: #fff;
    color: #e53935;

    font-size: 22px;

    box-shadow: 0 10px 25px rgba(0, 0, 0, .18);
}


/* =========================================================
   HERO TEXT
========================================================= */

.register-eyebrow {
    display: block;
    margin-bottom: 5px;

    color: #fff8dc;

    font-size: 11px;
    font-weight: 700;

    letter-spacing: 1.2px;
    text-transform: uppercase;
}

.register-hero h3 {
    margin: 0;

    color: #fff;

    font-size: 27px;
    font-weight: 700;

    line-height: 1.2;
}


/* =========================================================
   CLOSE
========================================================= */

.register-close {
    position: absolute;
    z-index: 10;

    top: 17px;
    right: 18px;

    width: 35px;
    height: 35px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: 1px solid rgba(255, 255, 255, .40);
    border-radius: 50%;

    background: rgba(255, 255, 255, .14);

    color: #fff;
    font-size: 13px;

    cursor: pointer;
    transition: all .3s ease;
}

.register-close:hover {
    background: #fff;
    color: #e53935;
    transform: rotate(90deg);
}


/* =========================================================
   BODY
========================================================= */

.register-body {
    padding: 27px 40px 27px;
    background: #fff;
}


/* =========================================================
   INTRO
========================================================= */

.register-intro {
    margin-bottom: 20px;
}

.register-intro p {
    margin: 0;

    color: #555;

    font-size: 13px;
    line-height: 1.65;
}


/* =========================================================
   FORM FIELD
========================================================= */

.register-field {
    margin-bottom: 15px;
}

.register-field label {
    display: block;
    margin-bottom: 7px;

    color: #252525;

    font-size: 13px;
    font-weight: 700;
}


/* =========================================================
   INPUT
========================================================= */

.register-input {
    width: 100%;
    height: 49px;

    display: flex;
    align-items: center;

    padding: 0 14px;

    border: 1px solid #dedede;
    border-radius: 9px;

    background: #fff;

    transition:
        border-color .25s ease,
        box-shadow .25s ease,
        background .25s ease;
}

.register-input:hover {
    border-color: #f0c36d;
}

.register-input:focus-within {
    border-color: #e53935;
    background: #fff;

    box-shadow:
        0 0 0 3px rgba(229, 57, 53, .10);
}


/* =========================================================
   INPUT ICON
========================================================= */

.register-input-icon {
    flex: 0 0 30px;

    display: flex;
    align-items: center;

    color: #888;
    font-size: 14px;

    transition: color .25s ease;
}

.register-input:focus-within .register-input-icon {
    color: #e53935;
}


/* =========================================================
   INPUT TEXT
========================================================= */

.register-input input {
    width: 100%;
    height: 100%;

    padding: 0;

    border: 0;
    outline: 0;

    background: transparent;
    color: #222;

    font-size: 13px;
    font-weight: 400;
}

.register-input input::placeholder {
    color: #999;
    opacity: 1;
}


/* =========================================================
   TERMS
========================================================= */

.register-terms {
    display: flex;
    align-items: flex-start;

    gap: 9px;

    margin: 4px 0 18px;
}

.terms-check {
    flex: 0 0 auto;

    width: 18px;
    height: 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    margin-top: 1px;

    border-radius: 4px;

    background: #fff3cd;
    color: #e53935;

    font-size: 9px;
}

.register-terms p {
    margin: 0;

    color: #666;

    font-size: 11px;
    line-height: 1.55;
}

.register-terms a {
    color: #e53935;
    font-weight: 700;
    text-decoration: none;
}

.register-terms a:hover {
    color: #c62828;
}


/* =========================================================
   REGISTER BUTTON
========================================================= */

.register-btn {
    width: 100%;
    height: 51px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 10px;

    border: 0;
    border-radius: 9px;

    background: linear-gradient(
        135deg,
        #e53935,
        #c62828
    );

    color: #fff;

    font-size: 14px;
    font-weight: 700;

    cursor: pointer;

    box-shadow:
        0 8px 20px rgba(229, 57, 53, .20);

    transition: all .3s ease;
}

.register-btn:hover {
    transform: translateY(-2px);

    background: linear-gradient(
        135deg,
        #c62828,
        #b71c1c
    );

    box-shadow:
        0 12px 25px rgba(229, 57, 53, .25);

    color: #fff;
}

.register-btn-icon {
    width: 27px;
    height: 27px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: rgba(255, 243, 205, .20);

    transition: transform .3s ease;
}

.register-btn:hover .register-btn-icon {
    transform: translateX(4px);
}


/* =========================================================
   LOGIN LINK
========================================================= */

.register-login-link {
    display: flex;
    align-items: center;
    justify-content: center;

    gap: 4px;

    margin-top: 20px;
    padding-top: 17px;

    border-top: 1px solid #eeeeee;

    color: #666;
    font-size: 12px;
}

.register-login-link a {
    color: #e53935;

    font-weight: 700;
    text-decoration: none;

    transition: color .25s ease;
}

.register-login-link a:hover {
    color: #c62828;
}


/* =========================================================
   DESKTOP
========================================================= */

@media (min-width: 992px) {

    #registerModal .modal-dialog {
        max-width: 520px;
    }

    .food-register-popup {
        border-radius: 24px;
    }

    .register-hero {
        min-height: 145px;
    }

    .register-hero-content {
        min-height: 145px;
        padding-left: 38px;
    }

    .register-body {
        padding: 30px 45px 30px;
    }

}


/* =========================================================
   TABLET
========================================================= */

@media (max-width: 767px) {

    #registerModal .modal-dialog {
        max-width: 470px;
    }

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 575px) {

    #registerModal .modal-dialog {
        width: auto;

        max-width: calc(100% - 18px);

        margin: 9px auto;
        padding: 0;
    }

    .food-register-popup {
        max-height: calc(100vh - 18px);
        border-radius: 18px;
    }

    .register-hero {
        min-height: 112px;
    }

    .register-hero-content {
        min-height: 112px;

        padding: 25px 48px 22px 22px;

        gap: 12px;
    }

    .register-icon {
        width: 50px;
        height: 50px;
        font-size: 18px;
    }

    .register-eyebrow {
        font-size: 9px;
        letter-spacing: .8px;
        margin-bottom: 4px;
    }

    .register-hero h3 {
        font-size: 21px;
    }

    .register-close {
        top: 12px;
        right: 12px;

        width: 32px;
        height: 32px;
    }

    .register-body {
        max-height: calc(100vh - 130px);

        overflow-y: auto;

        padding: 21px 20px 22px;

        -webkit-overflow-scrolling: touch;
    }

    .register-intro {
        margin-bottom: 17px;
    }

    .register-intro p {
        color: #555;

        font-size: 12px;
        line-height: 1.55;
    }

    .register-field {
        margin-bottom: 12px;
    }

    .register-field label {
        margin-bottom: 6px;

        color: #222;
        font-size: 12px;
    }

    .register-input {
        height: 47px;
        padding: 0 12px;
    }

    .register-input-icon {
        flex-basis: 28px;
        font-size: 13px;
    }

    .register-input input {
        font-size: 12px;
    }

    .register-input input::placeholder {
        color: #8a8a8a;
    }

    .register-terms {
        margin-top: 2px;
        margin-bottom: 15px;
    }

    .register-terms p {
        color: #555;
        font-size: 10px;
    }

    .register-btn {
        height: 49px;
        font-size: 13px;
    }

    .register-login-link {
        margin-top: 16px;
        padding-top: 14px;
        font-size: 11px;
    }

}


/* =========================================================
   VERY SMALL MOBILE
========================================================= */

@media (max-width: 380px) {

    #registerModal .modal-dialog {
        max-width: calc(100% - 12px);
    }

    .register-hero-content {
        padding-left: 17px;
        padding-right: 45px;

        gap: 10px;
    }

    .register-icon {
        width: 44px;
        height: 44px;
        font-size: 16px;
    }

    .register-hero h3 {
        font-size: 19px;
    }

    .register-eyebrow {
        font-size: 8px;
    }

    .register-body {
        padding-left: 16px;
        padding-right: 16px;
    }

}

</style>


{{-- =========================================================
     SWEETALERT2
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | REGISTER SUCCESS
    |--------------------------------------------------------------------------
    */

    @if (session('register_success'))

        Swal.fire({
            icon: 'success',
            title: 'Registration Successful!',
            text: @json(session('register_success')),
            confirmButtonText: 'Great!',
            confirmButtonColor: '#e53935',
            background: '#ffffff',
            color: '#222',
            customClass: {
                popup: 'food-swal-popup',
                confirmButton: 'food-swal-button'
            }
        });

    @endif


    /*
    |--------------------------------------------------------------------------
    | REGISTER VALIDATION ERROR
    |--------------------------------------------------------------------------
    */

    @if ($errors->register->any())

        const registerErrors = @json($errors->register->all());

        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            html: registerErrors
                .map(function (error) {
                    return '<div style="margin-bottom:5px;">' + error + '</div>';
                })
                .join(''),
            confirmButtonText: 'Try Again',
            confirmButtonColor: '#e53935',
            background: '#ffffff',
            color: '#222',
            customClass: {
                popup: 'food-swal-popup',
                confirmButton: 'food-swal-button'
            }
        }).then(function () {

            const registerModalElement =
                document.getElementById('registerModal');

            if (registerModalElement) {

                const registerModal =
                    bootstrap.Modal.getOrCreateInstance(
                        registerModalElement
                    );

                registerModal.show();
            }

        });

    @endif

});

</script>


<style>

/* =========================================================
   SWEETALERT FOOD THEME
========================================================= */

.food-swal-popup {
    border-radius: 18px !important;
    padding: 25px !important;
}

.food-swal-button {
    min-width: 110px;
    border-radius: 8px !important;
    font-weight: 700 !important;
}

</style>
