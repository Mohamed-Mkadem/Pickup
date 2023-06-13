<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('title')
    <link rel="shortcut icon" href="../../dist/Assets/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">

    <link rel="stylesheet" href=" {{ asset('dist/CSS/utilities.css') }} ">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/app.css') }} ">
    <link rel="stylesheet" href=" {{ asset('dist/CSS/app_dark.css') }} ">

    <!-- <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@44659d9/css/all.min.css" rel="stylesheet"
        type="text/css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" type="text/css">
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
        <aside id="aside" class="seller-aside" aria-current="expanded">
            <a href="{{ route('client.home') }}" class="logo d-block light visible"><i
                    class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span>
            </a>
            <button id="aside-toggle"><i class="fa-light fa-close"></i></button>



            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('client.home') }}"
                        class="nav-link {{ request()->is('client/home*') ? 'active' : '' }}">
                        <i class="fa-light fa-house"></i><span>Home</span>
                    </a>
                </li>





                <li class="nav-item"><a href="client_orders.html" class="nav-link notifiable">
                        <i class="fa-light fa-cart-arrow-down"></i>
                        <span>Orders</span></a></li>




                <li class="nav-item">
                    <a href="{{ route('client.balance') }}"
                        class="nav-link {{ request()->is('client/balance*') ? 'active' : '' }}">
                        <i class="fa-light fa-dollar-sign"></i>
                        <span>Balance</span></a>
                </li>

                <li class="nav-item">
                    <a href="shopping.html" class="nav-link">
                        <i class="fa-light fa-bag-shopping"></i>
                        <span>Shopping</span></a>
                </li>
                <li class="nav-item">
                    <a href="client_stores.html" class="nav-link">
                        <i class="fa-light fa-shop"></i>
                        <span>Stores</span></a>
                </li>








                <li class="nav-item"><a href="client_notifications.html" class="nav-link notifiable"> <i
                            class="fa-light fa-bell"></i>
                        <span>Notifications</span></a></li>





                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu" class="nav-link collapsed"> <i
                            class="fa-light fa-user-headset"></i> <span>Tickets</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="client_ticket_add.html">New Ticket</a></li>
                        <li class="nav-item"><a href="client_tickets.html">List</a></li>
                    </ul>
                </li>

            </ul>
        </aside>
        <main id="main-content">
            <!-- Header -->
            <header id="header" class="d-flex j-sp-between a-center">
                <!-- Layout Toggler -->
                <button id="layout-toggle" class="icon-btn "><i class="fa-light fa-bars"></i></button>


                <div class="dropdowns-holder d-flex  a-center">

                    <button aria-label="Enable / Disable Dark Mode" class="top-bar-btn" aria-current="Disabled"
                        id="mode-switcher">
                        <i class="fa-light fa-moon moon-icon"></i>
                        <i class="fa-light fa-sun sun-icon"></i>
                    </button>

                    <div class="dropdown-holder">
                        <button id="notifications-handler" data-count="99" class="top-bar-btn dropdown-toggle"
                            aria-pressed="false">
                            <i class="fa-light fa-bell"></i>
                        </button>
                        <div class="dropdown-menu notifications-dropdown ">
                            <h4>Notifications</h4>
                            <ul class="notifications-wrapper">
                                <!-- Start Notification -->
                                <li class="notification unread">
                                    <img src="../../dist/Assets/avatar-arthur.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href="" class="unread"> Lorem ipsum dolor sit amet consectetur
                                                adipisicing elit.
                                                Ducimus, non!</a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-light fa-timer"></i> 4 Hours ago
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification">
                                    <img src="../../dist/Assets/avatar-arthur.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href=""> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Ducimus, non!</a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-light fa-timer"></i> 4 Hours ago
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification">
                                    <img src="../../dist/Assets/avatar-arthur.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href=""> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Ducimus, non!</a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-light fa-timer"></i> 4 Hours ago
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification">
                                    <img src="../../dist/Assets/avatar-arthur.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href=""> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Ducimus, non!</a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-light fa-timer"></i> 4 Hours ago
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->
                                <!-- Start Notification -->
                                <li class="notification unread">
                                    <img src="../../dist/Assets/avatar-arthur.jpg" alt="">
                                    <div class="details">
                                        <p class="notification-body">
                                            <a href=""> Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                                Ducimus, non!</a>
                                        </p>
                                        <p class="notification-time">
                                            <i class="fa-light fa-timer"></i> 4 Hours ago
                                        </p>
                                    </div>
                                </li>
                                <!-- End Notification -->

                            </ul>
                            <a href="client_notifications.html" class="see-all d-block t-center">See All</a>
                        </div>
                    </div>

                    <div class="dropdown-holder">
                        <button id="profile-handler" class=" seller-client  dropdown-toggle" aria-pressed="false">
                            <div class="name-holder d-flex  a-center">
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">
                                <span>{{ Auth::user()->first_name }}</span>
                            </div>
                            <p class="balance-value"> {{ Auth::user()->client->balance }} DT</p>
                        </button>
                        <ul class="dropdown-menu profile-dropdown  ">
                            <li><a href="{{ route('client.profile') }}"><i class="fa-light fa-circle-user"></i>
                                    Profile</a></li>
                            <li><a href="{{ route('client.balance') }}"><i class="fa-light fa-dollar-sign"></i>
                                    Balance</a></li>
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

            </header>

            <div class="container fluid">


                @yield('content')
            </div>
        </main>
    </div>


    @stack('scripts')
    <script src="../../dist/js/app.js"></script>
</body>

</html>
