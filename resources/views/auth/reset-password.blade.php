{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | Reset Password</title>
    <link rel="shortcut icon" href=" {{ asset('dist/Assets/favicon.png') }} " type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href=" {{ asset('dist/CSS/utilities.css') }} ">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/fe_Dark.css') }} ">
    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />

    <style>
        .reset-password {
            min-height: 100vh;
            background-color: var(--clr-turquoise-800);
        }

        .reset-password .form-wrapper {
            width: min(600px, 90%);
            background-color: var(--clr-turquoise-900);
            padding: 2em;
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
        }

        .reset-password .form-wrapper h1 {
            color: var(--clr-teal-300);
            font-size: 30px;
        }

        .reset-password .form-wrapper>p {
            color: var(--clr-navy-200);
            letter-spacing: 1px;
            line-height: 1.7;
            margin-block: 0.5em;
        }

        .reset-password .form-wrapper form {}

        .reset-password .form-wrapper form .form-control {}



        .reset-password .form-wrapper form .form-control input {
            width: 100%;
            height: 45px;
            padding-inline: 1em;
            border-radius: 5px;
            border: 2px solid transparent;
            background-color: var(--clr-mustard-800);
            color: var(--clr-blueGray-900);
            outline: none;
        }

        .reset-password .form-wrapper form .form-control input:focus,
        .reset-password .form-wrapper form .form-control input:focus-within {
            border-color: var(--clr-blueGray-500);
            /* border-color: red !important; */

        }

        .reset-password .form-wrapper form .form-control p.message {
            margin-block: 0.3em;
            margin-inline: 0.2em;
            line-height: 1.7;
            letter-spacing: 1px;
            transition: display .3s ease;
            display: none;
        }

        .reset-password .form-wrapper form .form-control p.message.show {
            display: block;
        }

        .reset-password .form-wrapper form .form-control p.message.error {
            color: var(--clr-red-600);
        }

        .reset-password .form-wrapper form .form-control p.message.success {
            color: var(--clr-green-300);
        }

        .reset-password .form-wrapper form .buttons {}

        .reset-password .form-wrapper form .buttons button {
            background-color: var(--clr-teal-400);
            margin-block: 1em 0;
            padding: 0.7em 2em;
            color: var(--clr-white-1000);
            font-weight: bold;
            letter-spacing: 2px;
            border-radius: 5px;
            transition: background-color .3s ease;
        }

        .reset-password .form-wrapper form .buttons button:hover {
            background-color: var(--clr-teal-300);
        }

        p.error-message {
            color: var(--clr-red-600);
            margin-top: 5px;
        }

        label {
            color: var(--clr-blueGray-900);
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .dark label {
            color: var(--clr-blueGray-0);
        }
    </style>
</head>

<body>
    <main class="reset-password d-flex j-center a-center">
        <div class="form-wrapper">
            <h1>New Password</h1>
            <form action="{{ route('password.store') }}" method="post">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="form-control mb-1 mt-1">
                    <label for="" class="d-block">Email</label>
                    <input type="email" class="form-element" name="email" id="email"
                        placeholder="eg: joe@email.com" value="{{ old('email', $request->email) }}">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-control mb-1">
                    <label for="" class="d-block">New Password</label>
                    <input type="password" name="password" id="password" placeholder="New Password">
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                </div>
                <div class="form-control">
                    <label for="" class="d-block">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirm Password">
                    @error('password_confirmation')
                        <p class="error-message">{{ $message }}</p>
                    @enderror

                </div>
                <div class="buttons d-flex j-end">
                    <button type="submit">Reset</button>
                </div>
            </form>
        </div>
    </main>
    <script>
        let mode = sessionStorage.getItem("mode");
        if (mode) {
            enableDarkMode();
        }

        function enableDarkMode() {
            document.body.classList.add("dark");
            sessionStorage.setItem("mode", "dark");

        }
    </script>
</body>

</html>
