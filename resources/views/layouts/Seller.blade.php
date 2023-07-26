<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('title')
    <link rel="shortcut icon" href=" {{ asset('dist/Assets/favicon.png') }} " type="image/x-icon">
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
    <div class="preloader" id="preloader">
        <div class="loader-wrapper">
            <a href="{{ route('seller.home') }}" class="logo d-block visible"><i class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span> </a>
            <div class="circles">
                <div class="circle circle-1"></div>
                <div class="circle circle-2"></div>
                <div class="circle circle-3"></div>
                <div class="circle circle-4"></div>
                <div class="circle circle-4"></div>
            </div>
        </div>
    </div>
    <div id="overlay" class="overlay"></div>
    @stack('light-box')
    <div class="main-wrapper">
        <aside id="aside" class="seller-aside" aria-current="expanded">
            <a href="{{ route('seller.home') }}" class="logo d-block light visible"><i
                    class="fa-light fa-bag-shopping"></i>
                <span>Pickup</span>
            </a>
            <button id="aside-toggle"><i class="fa-light fa-close"></i></button>



            <ul class="nav-links">
                <li class="nav-item">
                    <a href="{{ route('seller.home') }}"
                        class="nav-link {{ request()->is('seller/home*') ? 'active' : '' }}">
                        <i class="fa-light fa-house"></i><span>Home</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('seller.categories.index') }}"
                        class="nav-link 
                            {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    {{ request()->is('seller/categories*') ? 'active' : '' }}
                    ">
                        <i class="fa-solid fa-list"></i>
                        <span>Categories</span></a>
                </li>

                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link 
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    {{ request()->is('seller/products*') ? 'active' : '' }}
                    collapsed">
                        <i class="fa-light fa-box"></i> <span>Products</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('seller.products.create') }}">New Product</a></li>
                        <li class="nav-item"><a href="{{ route('seller.products.index') }}">List Products</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{ route('seller.orders.index') }}"
                        class="nav-link
                        {{ request()->is('seller/order*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}

                    @if (Auth::user()->seller->hasActiveStore() && Auth::user()->seller->store->pendingordersCount() > 0) notifiable @endif
                    ">
                        <i class="fa-light fa-cart-arrow-down"></i>
                        <span>Orders</span></a>
                </li>



                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link
                        {{ request()->is('seller/sales*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    collapsed">
                        <i class="fa-light fa-hand-holding-dollar"></i> <span>Sales</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a
                                class=" {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.sales.create') }}">New Sale</a></li>
                        <li class="nav-item"><a
                                class=" {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.sales.index') }}">List </a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('seller.balance') }}"
                        class="nav-link {{ request()->is('seller/balance*') ? 'active' : '' }}">
                        <i class="fa-light fa-dollar-sign"></i>
                        <span>Balance</span></a>
                </li>

                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed
                        {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    {{ request()->is('seller/subscriptions*' ? 'active' : '') }}">
                        <i class="fa-light fa-box-dollar"></i> <span>Subscriptions</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.stores.subscriptions.create') }}">Add New</a>
                        </li>
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.stores.subscriptions.index') }}">List</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed  {{ request()->is('seller/requests*') ? 'active' : '' }}">
                        <i class="fa-light fa-memo-circle-info"></i>
                        <span>Requests</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('seller.verification-requests.index') }}"
                                class="">Verification</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('seller.payment-requests.index') }}"
                                class="
                               
                            {{ Auth::user()->seller->isVerified() ? '' : 'disabled-link' }}
                            ">Payment</a>
                        </li>
                    </ul>
                </li>




                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link collapsed 
                        {{ request()->is('seller/stores*') ? 'active' : '' }}
                        {{ Auth::user()->seller->isVerified() ? '' : 'disabled-link' }}
                        {{ !Auth::user()->seller->hasBannedStore() ? '' : 'disabled-link' }}
                    ">
                        <i class="fa-light fa-shop"></i> <span>Stores</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->isVerified() ? '' : 'disabled-link' }}
                                {{ !Auth::user()->seller->hasBannedStore() ? '' : 'disabled-link' }}
                                "
                                href="{{ route('seller.stores.create') }}">New Store</a></li>
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->isVerified() ? '' : 'disabled-link' }}
                                {{ !Auth::user()->seller->hasBannedStore() ? '' : 'disabled-link' }}
                                "
                                href="{{ route('seller.stores.index') }}">List</a></li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{ route('seller.inventory.index') }}"
                        class="nav-link 
                        {{ request()->is('seller/inventory*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    ">
                        <i class="fa-light fa-warehouse"></i>
                        <span>Inventory</span></a></li>
                <li class="nav-item"><a href="{{ route('seller.notifications.index') }}"
                        class="nav-link
                    {{ request()->is('seller/notifications*') ? 'active' : '' }}
                    @if (Auth::user()->unreadNotifications()->count() > 0) notifiable @endif

                    ">
                        <i class="fa-light fa-bell"></i>
                        <span>Notifications</span></a></li>





                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link
                    {{ request()->is('seller/ticket*') ? 'active' : '' }}
                    collapsed">
                        <i class="fa-light fa-user-headset"></i> <span>Tickets</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a href="{{ route('seller.tickets.create') }}">New Ticket</a></li>
                        <li class="nav-item"><a href="{{ route('seller.tickets.index') }}">List</a></li>
                    </ul>
                </li>








                <li class="nav-item"><a href="{{ route('seller.transfers.index') }}"
                        class="nav-link 
                        {{ request()->is('seller/transfers*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasStore() ? '' : 'disabled-link' }}
                    ">
                        <i class="fa-light fa-arrow-right-arrow-left"></i>
                        <span>Transfers</span></a></li>
                <li class="nav-item"><a href="{{ route('seller.reviews.index') }}"
                        class="nav-link 
                        {{ request()->is('seller/reviews*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    ">
                        <i class="fa-light fa-star"></i>
                        <span>Reviews</span></a></li>






                <li class="nav-item">
                    <a href="#" role="button" aria-controls="#sub-menu"
                        class="nav-link 
                        {{ request()->is('seller/earnings*') ? 'active' : '' }}
                        {{ request()->is('seller/expenses*') ? 'active' : '' }}
                        {{ request()->is('seller/revenues*') ? 'active' : '' }}
                    {{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}
                    collapsed">
                        <i class="fa-light fa-sack-dollar"></i> <span>Treasury</span></a>
                    <ul class="nav-sub-dropdown">
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.earnings.index') }}">Earnings</a></li>
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.revenues.index') }}">Revenues</a></li>
                        <li class="nav-item"><a
                                class="{{ Auth::user()->seller->hasActiveStore() ? '' : 'disabled-link' }}"
                                href="{{ route('seller.expenses.index') }}">Expenses</a></li>
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
                        <button id="profile-handler" class=" seller-client  dropdown-toggle" aria-pressed="false">
                            <div class="name-holder d-flex  a-center">
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="">
                                <span>{{ Auth::user()->first_name }}</span>
                            </div>
                            <p class="balance-value">{{ Auth::user()->seller->balance }} DT</p>
                        </button>
                        <ul class="dropdown-menu profile-dropdown  ">
                            <li><a href="{{ route('seller.profile') }}"><i class="fa-light fa-circle-user"></i>
                                    Profile</a></li>
                            <li><a href="{{ route('seller.balance') }}"><i class="fa-light fa-dollar-sign"></i>
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

    <audio id="notification-sound" src="{{ asset('dist/Assets/notification-sound.mp3') }}"></audio>
    @stack('scripts')
    <script>
        const prefix = "{{ Auth::user()->type }}"

        const user_id = {{ Auth::id() }}
        const baseUrl = "{{ asset('') }}";
    </script>

    <script src="{{ asset('dist/JS/app.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>

</body>

</html>
