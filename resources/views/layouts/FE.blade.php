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

    <link rel="stylesheet" href="{{ asset('dist/CSS/fe.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/utilities.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/CSS/fe_Dark.css') }}">


    @stack('styles')
    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    {{-- <div class="preloader" id="preloader">
        <div class="loader-wrapper">
            <a href="" class="logo d-block visible"><i class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span> </a>
            <div class="circles">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
                <div class="circle circle-4"></div>
                <div class="circle circle-4"></div>
            </div>
        </div>
    </div> --}}
    <div class="overlay" id="overlay"></div>
    <!-- Start Header -->
    <header>
        @guest


            <div class="top-menu">
                <div class="container">
                    <div class="wrapper">
                        <a class="start-selling-btn" href="{{ route('startSellingPage') }}"><i
                                class="fa-solid fa-sack-dollar"></i> Start
                            Selling</a>
                        <div class="seller-links">
                            <p role="button" aria-pressed="false" id="seller-dialogue-toggle" class="dropdown-toggle">
                                Seller
                                <span> : </span> <i class="fa-solid fa-caret-down"></i>
                            </p>
                            <ul class="links dropdown-menu" id="sellerDropdown">
                                <li><a href="{{ route('seller/login') }}" class="s-login"><i class="fa-light fa-user"></i>
                                        Login</a> </li>
                                <li class="span-holder"> <span> / </span> </li>
                                <li><a href="{{ route('sellerRegister') }}" class="s-register"><i
                                            class="fa-light fa-user-plus"></i>
                                        Register</a> </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        @endguest
        <div class="container">
            <div class="main-menu">
                <div class="col logo-col">
                    <button class="icon-btn " id="nav-toggle" aria-controls="#main-nav"><i
                            class="fa-light fa-bars"></i></button>
                    <a href="{{ route('homePage') }}" class="logo"><i class="fa-light fa-bag-shopping"></i>
                        <span>Pickup</span> </a>
                </div>
                <nav id="main-nav">
                    <button id="close-main-nav" aria-controls="#main-nav"><i
                            class="fa-light fa-square-xmark"></i></button>
                    <ul>
                        <li><a href="{{ route('homePage') }}" class="  {{ request()->is('/') ? 'active' : '' }}"><i
                                    class="fa-thin fa-house"></i> <span> Home </span></a>
                        </li>
                        <li><a href="{{ route('aboutPage') }}"
                                class=" {{ request()->is('about') ? 'active' : '' }}"><i
                                    class="fa-thin fa-circle-info"></i> <span> About </span></a></li>
                        <li><a href="{{ route('contactPage') }}"
                                class=" {{ request()->is('contact') ? 'active' : '' }}"><i
                                    class="fa-thin fa-user-headset"></i> <span> Contact </span></a>
                        </li>
                        <li><a href="{{ route('trackOrderPage') }}"
                                class=" {{ request()->is('track-order*') ? 'active' : '' }}"><i
                                    class="fa-thin fa-cart-plus"></i> <span> Track Order
                                </span></a></li>

                    </ul>
                </nav>
                <div class="col drops-col">
                    <div class="client-links">
                        @guest


                            <button class="icon-btn dropdown-toggle" id="client-dropdown-toggle" aria-pressed="false"
                                aria-controls="#client-dropdown"><i class="fa-light fa-circle-user"></i></button>
                            <ul class="links dropdown-menu" id="client-dropdown">
                                <li><a href="{{ route('login') }}" class="c-login"><i class="fa-light fa-user"></i>
                                        Login</a> </li>
                                <li><a href="{{ route('register') }}" class="c-register"><i
                                            class="fa-light fa-user-plus"></i> Register</a> </li>
                            </ul>
                        @endguest
                        @auth
                            <button class="icon-btn dropdown-toggle auth" id="auth-dropdown-toggle" aria-pressed="false"
                                aria-controls="#auth-dropdown"><i class="fa-light fa-circle-user"></i>
                                {{ Auth::user()->first_name }} <i class="fa-solid fa-caret-down"></i></button>
                            <ul class="links dropdown-menu auth" id="auth-dropdown">
                                @if (Auth::user()->type == 'Client')
                                    <li><a href="{{ route('client.home') }}" class="c-login"><i
                                                class="fa-light fa-house"></i> Dashboard</a></li>
                                @elseif(Auth::user()->type == 'Seller')
                                    <li><a href="{{ route('seller.home') }}" class="c-login"><i
                                                class="fa-light fa-house"></i> Dashboard</a></li>
                                @else
                                    <li><a href="{{ route('admin.home') }}" class="c-login"><i
                                                class="fa-light fa-house"></i> Dashboard</a></li>
                                @endif

                                <li>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit"><i class="fa-light fa-arrow-right-from-bracket">
                                            </i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        @endauth
                    </div>
                    <div class="switcher-holder">
                        <button aria-label="Enable / Disable Dark Mode" aria-current="Disabled" id="mode-switcher">
                            <i class="fa-solid fa-moon moon-icon"></i>
                            <i class="fa-light fa-sun sun-icon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->


    @yield('content')



    <!-- Start Footer -->
    <footer>
        <div class="container">
            <div class="footer-wrapper">
                <div class="col">
                    <ul>
                        <li>
                            <a href="{{ route('homePage') }}" class="logo visible light">
                                <i class="fa-light fa-bag-shopping"></i>
                                <span>Pickup</span>
                            </a>
                        </li>
                        <li><i class="fa-thin fa-location-dot"></i> Awesome Address - Bab Bhar - Tunis</li>
                        <li><i class="fa-thin fa-phone-flip fa-rotate-90"></i> +216 50 000 000</li>
                        <li><i class="fa-thin fa-envelope"></i> Email@email.com</li>
                    </ul>
                </div>
                <div class="col">
                    <h3 class="title">Help</h3>
                    <ul>
                        <li><a href="{{ route('faqsPage') }}">Faqs</a></li>
                        <li><a href="{{ route('contactPage') }}">Contact</a></li>
                        <li><a href="{{ route('trackOrderPage') }}">Track Order</a></li>
                        <li><a href="{{ route('termsPage') }}">Terms</a></li>
                        <li><a href="{{ route('privacyPage') }}">Privacy</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h3 class="title">Seller</h3>
                    <ul>
                        <li><a href="{{ route('startSellingPage') }}">Start Selling</a></li>
                        <li><a href="{{ route('sellerRegister') }}">Register</a></li>
                        <li><a href="{{ route('seller/login') }}">Login</a></li>
                    </ul>
                </div>
            </div>
            <div class="bottom-footer">
                <ul class="social-wrapper">
                    <li><a href=""><i class="fa-brands fa-facebook"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
                    <li><a href=""><i class="fa-brands fa-youtube"></i></a></li>
                </ul>
                <p class="copyrights"> &copy; All Rights Deserved</p>
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    @stack('scripts')
    <script src="{{ asset('dist/js/fe.js') }}"></script>
</body>

</html>
