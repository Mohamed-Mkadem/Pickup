{{-- <x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout> --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | Verify Email</title>
    <link rel="shortcut icon" href="../../dist/Assets/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="../../dist/CSS/utilities.css">
    <link rel="stylesheet" href="../../dist/CSS/fe_Dark.css">
    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />
    <style>
        .verify-email {
            background-color: var(--clr-blueGray-0);
            min-height: 100vh;
        }

        .verify-email-wrapper {
            width: min(500px, 95%);
            background-color: var(--clr-white-1000);
            padding: 1em 2em;
            letter-spacing: 1px;
            color: var(--clr-blueGray-900);
        }



        p.status-success {
            color: var(--clr-green-400);
            font-weight: 500;
        }

        button.logout-btn {
            text-decoration: underline;
            color: inherit;
            letter-spacing: inherit;
        }

        .dark .verify-email {
            background-color: var(--clr-black-50);
        }

        .dark .verify-email-wrapper {
            background-color: var(--clr-black-150);
            color: var(--clr-white-800);
        }
    </style>
</head>

<body>

    <main class="verify-email d-flex j-center a-center">
        <div class="verify-email-wrapper shadow-1  radius-10">
            <p class="thanks-message">
                Thanks for signing up! Before getting started, could you verify your email address by clicking on the
                link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.
            </p>

            @if (session('status') == 'verification-link-sent')
                <p class="status-success mt-1 mb-1">
                    A new verification link has been sent to the email address you provided during registration.'
                </p>
            @endif

            <div class="d-flex forms-holder j-sp-between a-center gap-1 wrap mt-2">
                <form action="{{ route('verification.send') }}" method="post">
                    @csrf
                    <button type="submit" class="submitBtn">Resend Verification Email</button>
                </form>

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
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
