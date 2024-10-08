<!doctype html>
<html lang="en">
<head>
    <title>Entrar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <link rel="stylesheet" href="{{ asset('css/login/style.css') }}">
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="wrap">
                    <div class="img" style="background-image: url({{ asset('images/login/background.webp') }});"></div>
                    <div class="login-wrap p-4 p-md-5">
                        <div class="d-flex">
                            <div class="w-100">
                                <h3 class="mb-4">Entrar</h3>
                            </div>
                            <div class="w">
                                <img src="{{ asset('images/logo.png') }}" width="100">
                            </div>
                    {{--    <div class="w-100">
                                <p class="social-media d-flex justify-content-end">
                                    <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                                    <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-twitter"></span></a>
                                </p>
                            </div>
                            --}}
                        </div>
                        <form action="{{ route('login') }}" method="POST" class="signin-form">
                            @csrf
                            @error('login')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <div class="form-group mt-3">
                                <input type="text" class="form-control" name="login" required>
                                <label class="form-control-placeholder" for="login">Login</label>
                            </div>

                            <div class="form-group mt-4">
                                <input id="password-field" type="password" class="form-control" name="password" required>
                                <label class="form-control-placeholder" for="password">Senha</label>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary rounded submit px-3" style="background: rgb(69,151,69) !important; border: none !important;">
                                    Entrar
                                </button>
                            </div>
                            <div class="form-group d-md-flex">
                         {{--       <div class="w-50 text-left">
                                    <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                        <input type="checkbox" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="w-50 text-md-right">
                                    <a href="#">Forgot Password</a>
                                </div>--}}
                            </div>
                        </form>
{{--
                        <p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>
--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>

