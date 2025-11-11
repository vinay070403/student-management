<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SkyDash Admin</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center mb-4">
                                <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo">
                            </div>

                            <h4 class="text-center">Hello! Let's get started</h4>
                            <h6 class="font-weight-light text-center mb-4">Sign in to continue.</h6>

                            <form class="pt-3" method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg"
                                        placeholder="Email" value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group position-relative">
                                    <input type="password" name="password" id="passwordInput"
                                        class="form-control form-control-lg" placeholder="Password">
                                    <i class="mdi mdi-eye-off position-absolute" id="togglePassword"
                                        style="right: 15px; top: 15px; cursor: pointer;"></i>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                @error('credential')
                                <span class="text-danger d-block mb-2">{{ $message }}</span>
                                @enderror

                                <div class="mt-3 d-grid">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg font-weight-medium auth-form-btn d-flex justify-content-center align-items-center gap-2">
                                        <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
                                        <span id="btnText">SIGN IN</span>
                                    </button>
                                </div>

                                <div class="text-center mt-4 font-weight-light">
                                    Forgot Password? <a href="{{ route('password.request') }}" class="text-primary">Click
                                        here</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = form.querySelector('input[name="email"]');
            const passwordInput = form.querySelector('input[name="password"]');
            const togglePassword = document.getElementById('togglePassword');
            const spinner = document.getElementById('loadingSpinner');
            const btnText = document.getElementById('btnText');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Password show/hide toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('mdi-eye');
                this.classList.toggle('mdi-eye-off');
            });

            // Form validation
            form.addEventListener('submit', function(e) {
                // Clear previous JS validation messages
                form.querySelectorAll('.text-danger.js-error').forEach(el => el.remove());

                let hasError = false;

                // Email validation
                const emailValue = emailInput.value.trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailValue === '') {
                    showError(emailInput, 'Email is required.');
                    hasError = true;
                } else if (!emailRegex.test(emailValue)) {
                    showError(emailInput, 'Please enter a valid email address.');
                    hasError = true;
                }

                // Password validation
                const passwordValue = passwordInput.value.trim();
                if (passwordValue === '') {
                    showError(passwordInput, 'Password is required.');
                    hasError = true;
                } else if (passwordValue.length < 6) {
                    showError(passwordInput, 'Password must be at least 6 characters long.');
                    hasError = true;
                }

                if (hasError) {
                    e.preventDefault();
                    return;
                }

                // If valid, show spinner and disable button
                spinner.classList.remove('d-none');
                btnText.textContent = 'Signing in...';
                submitBtn.disabled = true;
            });

            function showError(input, message) {
                const error = document.createElement('span');
                error.classList.add('text-danger', 'js-error');
                error.style.display = 'block';
                error.style.marginTop = '5px';
                error.textContent = message;
                input.insertAdjacentElement('afterend', error);
            }
        });
    </script>

    <!-- SweetAlert2 for backend flash messages -->
    @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{!! session('success') !!}",
            timer: 2000,
            showConfirmButton: false
        });
    </script>
    @endif

    @if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: '{{ session("error") }}',
        });
    </script>
    @endif
</body>

</html>