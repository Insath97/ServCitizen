<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ getSettingInfo('site_name') }}</title>

    <link rel="icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            display: flex;
            height: 80vh;
            max-width: 960px;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
        }

        .login-image {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }

        .login-image img {
            max-width: 100%;
            height: auto;
        }

        .login-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
            background-color: #fff;
        }

        .login-form .card {
            border: none;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .login-brand img {
            width: 50px;
        }

        .simple-footer {
            text-align: center;
            margin-top: 1rem;
        }

        /* Mobile responsiveness */
        @media (max-width: 767.98px) {
            .login-container {
                flex-direction: column;
                height: auto;
            }

            .login-image {
                display: none;
                /* Hide image on small screens */
            }

            .login-form {
                padding: 1rem;
                margin-top: 80px;
            }
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container-fluid login-container">
                <div class="login-image bg-primary">
                    <img src="{{ asset('images/servCitizen.png') }}" alt="Company Logo">
                </div>
                <div class="login-form">
                    <div class="login-brand text-center" style="margin-top: 40px;">
                        <img src="{{ asset('images/logo.png') }}" alt="logo">
                        <p class="mt-3" style="font-weight: bold;">DS OFFICE -
                            {{ getSettingInfo('site_office_name') }}</p>

                    </div>
                    <div class="" style="margin-top: -40px;">
                        <div class="">
                        </div>
                        <div class="">
                            @if (session()->has('success'))
                                <div class="alert alert-primary alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="alert">
                                            <span>×</span>
                                        </button>
                                        {{ session()->get('success') }}
                                    </div>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.handle-login') }}" class="needs-validation"
                                novalidate="">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email"
                                        tabindex="1" required autofocus>
                                    <div class="invalid-feedback">Please fill in your email</div>
                                    @error('email')
                                        <code>{{ $message }}</code>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password" class="control-label">Password</label>
                                    <div class="float-right">
                                        <a href="{{ route('admin.forgot-password') }}" class="text-small">Forgot
                                            Password?</a>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password"
                                        tabindex="2" required>
                                    <div class="invalid-feedback">Please fill in your password</div>
                                    @error('password')
                                        <code>{{ $message }}</code>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input"
                                            tabindex="3" id="remember-me">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"
                                        tabindex="4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer text-center text-muted small">
                Powered by DS Office {{ getSettingInfo('site_office_name') }} &copy; {{ date('Y') }} <div
                    class="bullet"></div> Sytem Designed & Developed By
                <a href="https://github.com/Insath97" target="_blank">{{ getSettingInfo('site_company_name') }}</a>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('admin/assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
</body>

</html>
