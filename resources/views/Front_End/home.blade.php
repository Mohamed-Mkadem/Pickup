@extends('layouts.FE')
@push('title')
<title>Pickup | Home</title>
@endpush

@section('content')
<main class="home">
    <!-- Start Showcase -->
    <div class="showcase">
        <div class="container">
            <div class="showcase-wrapper">
                <div class="text-info col">
                    <h1 class="h1-title title">Browse, Order, Pick Up!</h1>
                    <!-- <h1 class="main-title">تصفح، اطلب، استلم</h1> -->
                    <p>Daily Shopping Simplified</p>
                    <a href="#what-is-pickup" class="btn cta-btn outlined-btn">More Info</a>
                </div>
                <div class="image-holder col">
              
                    <img loading="lazy" src=" {{ asset('dist/Assets/home_showcase_screenshot.png') }}" alt="">
                </div>
            </div>
        </div>

    </div>
    <!-- End Showcase -->

    <!-- Start What Is Pickup -->
    <section class="section" id="what-is-pickup">
        <div class="container">
            <div class="what-is-wrapper d-flex j-sp-between a-center col md-row">
                <div class="info">
                    <h2 class="title main-title">What Is Pickup ?</h2>
                    <p>Pickup it's the ultimate solution for all your shopping
                        needs. Designed to provide a seamless experience, Pickup brings together a diverse range of
                        vendors and sellers, making daily shopping hassle-free. Discover which stores in your city
                        have the products you're looking for, and enjoy the convenience of a one-stop platform.</p>
                    <a href="{{ route('aboutPage') }}" class="btn cta-btn">Read More</a>
                </div>
                <div class="img-holder">
                    <img loading="lazy" src="{{ asset('dist/Assets/e-shopping.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End What Is Pickup -->


    <!-- Start Why Pickup ? -->
    <section class="section">
        <div class="container">
            <h2 class="title main-title t-center">Why Pickup ?</h2>
            <div class="features-wrapper wrapper">

                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-light fa-cart-arrow-down"></i>
                        <h3 class="title h3-title">Order Management</h3>
                    </header>
                    <p>
                        We simplify the order management process for you. track your
                        orders, receive notifications, and manage deliveries from different vendors through a
                        unified interface
                    </p>
                </div>
                <!-- End Feature -->
                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-light fa-badge-check"></i>
                        <h3 class="title h3-title">Find The Best Deals</h3>
                    </header>
                    <p>
                        our clients can easily filter products by price and location,Rate ensuring they find the
                        most competitive prices and convenient options in their state or city.
                    </p>
                </div>
                <!-- End Feature -->
                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-solid fa-handshake"></i>
                        <h3 class="title h3-title">Transparency</h3>
                    </header>
                    <p>
                        Pickup Clients can view ratings and reviews from other customers to make informed decisions
                        about the quality of the products and services provided by each vendor
                    </p>
                </div>
                <!-- End Feature -->
                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-light fa-home"></i>
                        <h3 class="title h3-title">Convenience</h3>
                    </header>
                    <p>
                        Pickup Clients can easily browse products and Place the order without leaving their home.
                    </p>
                </div>
                <!-- End Feature -->
                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-light fa-timer"></i>
                        <h3 class="title h3-title">Time-Saving</h3>
                    </header>
                    <p>
                        Pickup Clients will save time by not having to visit multiple grocery stores to find the
                        products they need.
                    </p>
                </div>
                <!-- End Feature -->

                <!-- Start Feature -->
                <div class="feature">
                    <header class="d-flex a-center">
                        <i class="fa-light fa-user-headset"></i>
                        <h3 class="title h3-title">Customer Service</h3>
                    </header>
                    <p>
                        Our customer service goes above and beyond to ensure a seamless and satisfying experience
                        for our clients.
                    </p>
                </div>
                <!-- End Feature -->
            </div>
        </div>

    </section>
    <!-- End Why Pickup ? -->

    <!-- Start Avaiable Sectors -->
    <section class="section">
        <div class="container">
            <h2 class="title main-title t-center">What You Find In Pickup ?</h2>

            <div class="sectors-wrapper wrapper">
                <!-- Start Sector -->
                <div class="sector">
                    <img loading="lazy" src="{{ asset('dist/Assets/grocery.png') }}" alt="">
                    <h3 class="title t-center">Groceries</h3>
                </div>
                <!-- End Sector -->
                <!-- Start Sector -->
                <div class="sector">
                    <img loading="lazy" src="{{ asset('dist/Assets/bakery.png') }}" alt="">
                    <h3 class="title t-center">Bakeries</h3>
                </div>
                <!-- End Sector -->
                <!-- Start Sector -->
                <div class="sector">
                    <img loading="lazy" src="{{ asset('dist/Assets/library.png') }}" alt="">
                    <h3 class="title t-center">Libraries</h3>
                </div>
                <!-- End Sector -->
            </div>
        </div>
    </section>
    <!-- End Avaiable Sectors -->

    <!-- Start How It Works  -->
    <section class="section how-it-works">
        <div class="container">
            <h2 class="title main-title t-center">How It Works ?</h2>
            <div class="steps-wrapper wrapper">
                <!-- Start Column -->
                <div class="steps-col">
                    <!-- Start Step -->
                    <div class="step">
                        <h3 class="title"><span>01. </span>Create Your Account</h3>
                        <p>Seamlessly Begin Your Journey with a Quick and Easy Account Creation Process.</p>
                    </div>
                    <!-- End Step -->
                    <!-- Start Step -->
                    <div class="step">
                        <h3 class="title"><span>02. </span>Find A Store</h3>
                        <p>Explore a Diverse Range of Stores in Your City and Handpick Your Preferred Shopping
                            Destination</p>
                    </div>
                    <!-- End Step -->
                </div>
                <!-- End Column -->
                <!-- Start Column -->
                <div class="steps-col d-flex col">
                    <!-- Start Step -->
                    <div class="step logo-holder">
                        <a href="#" class="logo"><i class="fa-light fa-bag-shopping"></i> <span>Pickup</span> </a>

                    </div>
                    <!-- End Step -->
                    <!-- Start Step -->
                    <div class="step">
                        <h3 class="title"><span>03. </span>Browse Products</h3>
                        <p>All Stores Products are at Your Fingertips. Explore, Discover, and Find Everything You
                            Need in One Convenient Place.</p>
                    </div>
                    <!-- End Step -->
                </div>
                <!-- End Column -->
                <!-- Start Column -->
                <div class="steps-col">
                    <!-- Start Step -->
                    <div class="step">
                        <h3 class="title"><span>04. </span>Place an Order</h3>
                        <p>From Your Home. Simply Click,
                            Confirm, and Get Ready to Pick Your Desired Items.</p>
                    </div>
                    <!-- End Step -->
                    <!-- Start Step -->
                    <div class="step">
                        <h3 class="title"><span>05. </span>Pick The Order</h3>
                        <p>Get Notified When Your Order is Ready and Conveniently Pick Up Your Order at the
                            Designated Location for a Seamless Experience.</p>
                    </div>
                    <!-- End Step -->
                </div>
                <!-- End Column -->
            </div>
            <a href="{{ route('register') }}" class="cta-btn btn t-center d-block">Start The Journey</a>
        </div>
    </section>
    <!-- End How It Works  -->


    <!-- Start Weekly Vendors -->
    <section class="section top-vendors">
        <div class="container">
            <h2 class="main-title title t-center">Top Vendors Of The Week</h2>
            <div class="vendors-wrapper wrapper">
                <!-- Start Vendor -->
                <div class="vendor">
                    <header>
                        <p class="rank"> <span>#</span>1</p>
                        <p class="rate"><i class=" fa-solid fa-star"></i> <span>90%</span></p>
                    </header>
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/store.svg') }}" alt="">
                        <h3>Magico Store <i class="fa-solid fa-badge-check"></i></h3>
                        <p>Ariana - Mnihla</p>
                    </div>
                </div>
                <!-- End Vendor -->
                <!-- Start Vendor -->
                <div class="vendor">
                    <header>
                        <p class="rank"> <span>#</span>2</p>
                        <p class="rate"><i class=" fa-solid fa-star"></i> <span>90%</span></p>
                    </header>
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/store.svg') }}" alt="">
                        <h3>Magico Store <i class="fa-solid fa-badge-check"></i></h3>
                        <p>Ariana - Mnihla</p>
                    </div>
                </div>
                <!-- End Vendor -->
                <!-- Start Vendor -->
                <div class="vendor">
                    <header>
                        <p class="rank"> <span>#</span>2</p>
                        <p class="rate"><i class=" fa-solid fa-star"></i> <span>90%</span></p>
                    </header>
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/store.svg') }}" alt="">
                        <h3>Magico Store <i class="fa-solid fa-badge-check"></i></h3>
                        <p>Ariana - Mnihla</p>
                    </div>
                </div>
                <!-- End Vendor -->
            </div>
        </div>
    </section>
    <!-- Start CTA -->
    <section class="section cta">
        <div class="container">
            <div class="cta-wrapper t-center">
                <p><i class="fa-solid fa-users"></i> +10.000 Tunisians Already Joined Pickup</p>
                <h3 class="cta-title">What are you waiting to join us ?</h3>
                <a href="{{ route('register') }}" class="btn cta-btn">Sign-Up Now</a>
            </div>
        </div>
    </section>
    <!-- End CTA -->

</main>
@endsection