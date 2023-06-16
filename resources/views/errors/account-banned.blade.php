<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | Account Banned</title>
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href=" {{ asset('dist/CSS/utilities.css') }} ">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/fe_Dark.css') }} ">
    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />
    <style>
        .account-banned {
            background-color: var(--clr-blueGray-0);
            min-height: 100vh;
        }

        .account-banned-wrapper {
            width: min(600px, 95%);
            background-color: var(--clr-white-1000);
            padding: 1em 2em;
            letter-spacing: 1px;
            color: var(--clr-blueGray-900);
        }

        p.message {
            letter-spacing: 1px;
            line-height: 1.5;
            margin-top: .4em;
        }

        a {
            color: inherit;
            font-weight: bold;
            text-decoration: underline;
            letter-spacing: 2px;
            transition: color .3s ease-in;
        }

        a:hover {
            color: var(--clr-teal-400);
        }



        button.logout-btn {
            text-decoration: underline;
            color: inherit;
            letter-spacing: inherit;
        }

        .dark .account-banned {
            background-color: var(--clr-black-50);
        }

        .dark .account-banned-wrapper {
            background-color: var(--clr-black-150);
            color: var(--clr-white-800);
        }
    </style>
</head>

<body>

    <main class="account-banned d-flex j-center a-center">
        <div class="account-banned-wrapper shadow-1  radius-10">
            <h3>Account Banned</h3>
            <p class="message  ">
                We regret to inform you that your account has been banned due to violation of our platform's terms and
                conditions. As a result, your access to the platform has been restricted indefinitely. You will no
                longer be able to perform any actions or access any features on our platform. <br> If you believe this
                ban is
                in error or would like to appeal it, please <a href="{{ route('contactPage') }}">contact</a> our support
                team. <br> Thank
                you for
                your understanding.
            </p>


            <form action="{{ route('logout') }}" method="post" class="d-flex j-end mt-1">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
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
