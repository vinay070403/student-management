    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - SkyDash Admin</title>
        <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    </head>

    <body>
        <div class="container-scroller">
            <div class="container-fluid page-body-wrapper full-page-wrapper">
                <div class="content-wrapper d-flex align-items-center auth px-0">
                    <div class="row w-100 mx-0">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                                <div class="brand-logo">
                                    <img src="{{ asset('assets/images/logo1.svg') }}" alt="logo">
                                </div>
                                <h4>Hello! Let's get started</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                                <form class="pt-3" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Email" value="{{ old('email') }}">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @error('credential')
                                    <span class="text-danger d-block mb-2">{{ $message }}</span>
                                    @enderror

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                    </div>

                                    <div class="text-center mt-4 font-weight-light">
                                        Forgot Password? <a href="{{ route('password.request') }}" class="text-primary">Click here</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
        <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const emailInput = form.querySelector('input[name="email"]');
            const passwordInput = form.querySelector('input[name="password"]');

            form.addEventListener('submit', function(e) {
                // Clear any previous error messages
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

                // Prevent form submission if validation fails
                if (hasError) {
                    e.preventDefault();
                }
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


    </html>