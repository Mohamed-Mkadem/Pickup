<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('title')
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('dist/CSS/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/app.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/app_dark.css') }}">

    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />

</head>


<body>
    <!-- <div class="preloader" id="preloader">
        <div class="loader-wrapper">
            <a href="index.html" class="logo d-block visible"><i class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span> </a>
            <div class="circles">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
                <div class="circle circle-4"></div>
                <div class="circle circle-4"></div>
            </div>
        </div>
    </div> -->
    <div id="overlay" class="overlay"></div>
    <div class="main-wrapper">
        <!-- Start Header -->
        <header id="header" class=" store-fixed-header">
            <div class="container fluid">

                <div class="d-flex j-sp-between a-center">
                    <a href="{{ route('client.home') }}" class="logo d-block  visible"><i
                            class="fa-light fa-bag-shopping"></i>
                        <span>Pickup</span>
                    </a>

                    <div class="dropdowns-holder d-flex  a-center">
                        <button aria-label="Enable / Disable Dark Mode" class="top-bar-btn" aria-current="Disabled"
                            id="mode-switcher">
                            <i class="fa-light fa-moon moon-icon"></i>
                            <i class="fa-light fa-sun sun-icon"></i>
                        </button>

                        <x-notification-menu />
                        <div class="dropdown-holder">
                            <button id="profile-handler" class=" d-flex  a-center dropdown-toggle" aria-pressed="false">
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">
                                <span>{{ Auth::user()->first_name }}</span>
                            </button>
                            <ul class="dropdown-menu profile-dropdown  ">
                                <li><a href="{{ route('client.home') }}"><i class="fa-light fa-home"></i> Dashboard</a>
                                </li>
                                <li><a href="{{ route('client.profile') }}"><i class="fa-light fa-circle-user"></i>
                                        Profile</a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit"><i class="fa-light fa-arrow-right-from-bracket">
                                            </i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- End Header -->
        <main id="store-main-content">

            <div class="container  ">
                <section class="content" id="store-holder">


                    @yield('content')

                </section>
            </div>
        </main>
    </div>



    <script src="{{ asset('dist/js/store.js') }}"></script>
    @stack('scripts')
</body>

</html>
