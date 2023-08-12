<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | Login</title>
    <link rel="shortcut icon" href=" {{ asset('dist/Assets/favicon.png') }} " type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/fe.css') }} ">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/utilities.css') }} ">
    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
 
    <main class="client login">
        <div class="login-wrapper">
            <a href="{{ route('homePage') }}" class="logo visible d-block light m-auto"><i
                    class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span>
            </a>
            <p class="error-message t-center">- This Credentials do not match our records</p>
            <form action="{{ route('login') }}" method="post" id="login-form">
                @csrf
                <div class="form-control">
                    <input type="email" name="email" value="{{ old('email') }}" class="form-element" id="email"
                        placeholder="Email Address">
                    <p class="error-message ">This Field Is required</p>
                    @error('email')
                        <p class="error-message show"> {{ $message }}</p>
                    @enderror
                </div>
                <div class="form-control">

                    <input type="password" class="form-element" placeholder="Password" name="password" id="passowrd">
                    <p class="error-message ">This Field Is required</p>
                    @error('password')
                        <p class="error-message show"> {{ $message }}</p>
                    @enderror
                    <a href="{{ route('password.request') }}" class="forgot-password d-block ">Reset Password</a>
                </div>
                <div class="form-control">
                    <button type="submit" class="d-block">LOGIN</button>
                </div>
                <div class="form-control">
                    <p><span>Don't Have An Account ?</span> <a href="{{ route('register') }}">Create One</a> </p>
                </div>
            </form>
        </div>
    </main>


    <script src=" {{ asset('dist/JS/loginValidation.js') }} "></script>
</body>

</html>
