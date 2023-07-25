<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('title')
    @stack('meta')
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
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
    {{-- <div class="preloader" id="preloader">
        <div class="loader-wrapper">
            <a href="{{ route('admin.home') }}" class="logo d-block visible"><i class="fa-light fa-bag-shopping"></i>
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

    <div id="overlay" class="overlay"></div>
    @yield('loader')
    @stack('light-box')
    <div class="main-wrapper">
        <aside id="aside" class="" aria-current="expanded">
            <a href="{{ route('admin.home') }}" class="logo d-block light visible"><i
                    class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span>
            </a>
            <button id="aside-toggle"><i class="fa-light fa-close"></i></button>



            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('admin.home') }}"
                        class="nav-link {{ request()->is('admin/home*') ? 'active' : '' }}">
                        <i class="fa-light fa-house"></i><span>Home</span>
                    </a>
                </li>



                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed {{ request()->is('admin/brands*') ? 'active' : '' }}"> <i
                            class="fa-light fa-medal"></i> <span>Brands</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('admin.brands.create') }}">New Brand</a></li>
                        <li class="nav-item"><a href="{{ route('admin.brands.index') }}">List</a></li>

                    </ul>
                </li>


                <li class="nav-item"><a href="{{ route('admin.vouchers-categories.index') }}"
                        class="nav-link {{ request()->is('admin/vouchers-categories*') ? 'active' : '' }}">
                        <i class="fa-solid fa-credit-card-front"></i>
                        <span>Vouchers
                            Categories</span></a>
                </li>

                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed {{ request()->is('admin/vouchers/*') ? 'active' : '' }}">
                        <i class="fa-light fa-credit-card"></i>
                        <span>Vouchers</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('admin.vouchers.create') }}">New Vouchers</a></li>
                        <li class="nav-item"><a href="{{ route('admin.vouchers.index') }}">List</a></li>

                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('admin.sectors.index') }}"
                        class="nav-link {{ request()->is('admin/sectors*') ? 'active' : '' }}"> <i
                            class="fa-solid fa-chart-pie"></i>
                        <span>Sectors</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.fees.index') }}"
                        class="nav-link {{ request()->is('admin/fees*') ? 'active' : '' }}"><i
                            class="fa-solid fa-money-check-dollar-pen"></i> <span>Fees</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed notifiable {{ request()->is('admin/requests*') ? 'active' : '' }}">
                        <i class="fa-light fa-memo-circle-info"></i>
                        <span>Requests</span></a>
                    <ul class="nav-sub-dropdown">

                        <li class="nav-item"><a href="{{ route('admin.verification-requests.index') }}"
                                class="notifiable">Verification</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('admin.payment-requests.index') }}"
                                class=" 
                             notifiable
                             ">Payment</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a href="{{ route('admin.notifications.index') }}"
                        class="nav-link
                    
                    {{ request()->is('admin/notifications*') ? 'active' : '' }}
                    notifiable">
                        <i class="fa-light fa-bell"></i>
                        <span>Notifications</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.subscriptions.index') }}"
                        class="nav-link
                    {{ request()->is('admin/subscriptions*') ? 'active' : '' }}
                    notifiable">
                        <i class="fa-light fa-box-dollar"></i>
                        <span>Subscriptions</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.tickets.index') }}"
                        class="nav-link
                        {{ request()->is('admin/ticket*') ? 'active' : '' }}
                    
                    notifiable">
                        <i class="fa-light fa-user-headset"></i>
                        <span>Tickets</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}"
                        class="nav-link 
                    {{ request()->is('admin/order*') ? 'active' : '' }}
                    notifiable">
                        <i class="fa-light fa-cart-arrow-down"></i>
                        <span>Orders</span></a></li>

                <li class="nav-item">
                    <a href="{{ route('admin.sales.index') }}"
                        class="nav-link
                    {{ request()->is('admin/sales*') ? 'active' : '' }}
                    notifiable">
                        <i class="fa-light fa-hand-holding-dollar"></i>
                        <span>Sales</span>
                    </a>
                </li>

                <li class="nav-item"><a href="{{ route('admin.clients.index') }}"
                        class="nav-link notifiable 
                    {{ request()->is('admin/clients*') ? 'active' : '' }}">
                        <i class="fa-light fa-users"></i>
                        <span>Clients</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.sellers.index') }}"
                        class="nav-link notifiable
                    {{ request()->is('admin/sellers*') ? 'active' : '' }}">
                        <i class="fa-light fa-users-viewfinder"></i>
                        <span>Sellers</span></a></li>





                <li class="nav-item"><a href="{{ route('admin.transfers.index') }}"
                        class="
                    {{ request()->is('admin/transfers*') ? 'active' : '' }}
                    nav-link notifiable">
                        <i class="fa-light fa-arrow-right-arrow-left"></i>
                        <span>Transfers</span></a></li>
                <li class="nav-item"><a href="{{ route('admin.stores.index') }}"
                        class="nav-link notifiable {{ request()->is('admin/stores*') ? 'active' : '' }}"> <i
                            class="fa-light fa-shop"></i>
                        <span>Stores</span></a></li>





                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link 
                    {{ request()->is('admin/expenses*') ? 'active' : '' }}
                    {{ request()->is('admin/revenues*') ? 'active' : '' }}
                    {{ request()->is('admin/earnings*') ? 'active' : '' }}
                    collapsed">
                        <i class="fa-light fa-sack-dollar"></i> <span>Treasury</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('admin.earnings.index') }}">Earnings</a></li>
                        <li class="nav-item"><a href="{{ route('admin.revenues.index') }}">Revenues</a></li>
                        <li class="nav-item"><a href="{{ route('admin.expenses.index') }}">Expenses</a></li>
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



                    <x-notification-menu />

                    <div class="dropdown-holder">
                        <button id="profile-handler" class=" d-flex  a-center dropdown-toggle" aria-pressed="false">

                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">


                            <span>{{ Auth::user()->first_name }}</span>
                        </button>
                        <ul class="dropdown-menu profile-dropdown  ">
                            <li><a href="{{ route('admin.profile') }}"><i class="fa-light fa-circle-user"></i>
                                    Profile</a></li>
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

    <audio id="notification-sound" src="{{ asset('dist/Assets/notification-sound.mp3') }}"></audio>
    @stack('scripts')
    <script>
        const prefix = "{{ Auth::user()->type }}"
        const user_id = {{ Auth::id() }}
        const baseUrl = "{{ asset('') }}";
    </script>


    <script src="{{ asset('dist/js/app.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>
