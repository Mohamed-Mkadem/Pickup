@extends('layouts.FE')
@push('title')
    <title>Pickup | Start Selling</title>
@endpush
@push('styles')
    <link rel="stylesheet" href="//unpkg.com/a11y-slider@latest/dist/a11y-slider.css" />
@endpush

@section('content')
    <main class="start-selling">
        <!-- Start Showcase -->
        <div class="showcase start-selling">
            <div class="container">
                <div class="showcase-wrapper">
                    <div class="text-info col">
                        <h1 class="h1-title title sm-line-h-1">Pickup Increases Your Earnings</h1>
                        <p>

                            Reach new customers and boost sales, With Pickup you gain access to a wider network of
                            buyers searching for fresh goods.

                        </p>
                        <a href="#offers" class="btn cta-btn outlined-btn">More Info</a>
                    </div>
                    <div class="image-holder col">
                        <img loading="lazy" src="{{ asset('dist/Assets/home_showcase_screenshot.png ') }} " alt="">
                    </div>
                </div>
            </div>

        </div>
        <!-- End Showcase -->

        <!-- Start Features -->
        <section class="section" id="offers">
            <div class="container">

                <h2 class="title main-title t-center">We Offer To You</h2>
                <div class="features-wrapper wrapper">
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-users"></i>
                            <h3 class="title h3-title">Boost Your Visibility</h3>
                        </header>
                        <p>
                            Gain increased exposure for your store as our platform connects you with a larger customer
                            base, expanding your reach beyond the confines of a physical store.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-warehouse"></i>
                            <h3 class="title h3-title">Inventory Management</h3>
                        </header>
                        <p>
                            Streamline your operations with our intuitive inventory management feature, allowing you to
                            efficiently track and organize your products, ensuring optimal stock levels and reducing the
                            chances of overselling or stockouts
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-screwdriver-wrench"></i>
                            <h3 class="title h3-title">Easy Setup</h3>
                        </header>
                        <p>
                            Pickup provides an easy setup process for you, which can save time and effort compared to
                            building your own e-commerce website.
                        </p>
                    </div>
                    <!-- End Feature -->

                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-chart-mixed"></i>
                            <h3 class="title h3-title">Profit Insights</h3>
                        </header>
                        <p>
                            Gain valuable financial visibility with our comprehensive tracking tool, empowering you to
                            monitor expenses, revenues, and profitability trends on a daily, weekly, monthly, and yearly
                            basis.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-magnifying-glass-dollar"></i>
                            <h3 class="title h3-title">Sales Tracking</h3>
                        </header>
                        <p>
                            Streamline your transactions and effortlessly monitor your sales in real-time. Our intuitive
                            POS system provides detailed insights on your daily, weekly, and monthly sales, helping you
                            stay informed and optimize your business performance.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-hand-holding-dollar"></i>
                            <h3 class="title h3-title">Flexible Withdrawals</h3>
                        </header>
                        <p>
                            Take control of your earnings with our platform. Request withdrawals at your convenience,
                            giving you the freedom to access your funds whenever you need them. Enjoy hassle-free
                            transactions and prompt payments.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-box-dollar"></i>
                            <h3 class="title h3-title">Flexible Subscription System</h3>
                        </header>
                        <p>
                            Empower your business with our flexible subscription system. Choose the plan that suits your
                            needs and unlock a range of exclusive benefits and features. Enjoy the freedom to customize
                            your subscription anytime.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-user-headset"></i>
                            <h3 class="title h3-title">Dedicated Support Team</h3>
                        </header>
                        <p>
                            Our friendly and knowledgeable support team is here to assist you every step of the way.
                            With a genuine commitment to your success, our team is ready to help you overcome any
                            challenges you encounter, ensuring your selling experience is smooth and worry-free.
                        </p>
                    </div>
                    <!-- End Feature -->
                    <!-- Start Feature -->
                    <div class="feature">
                        <header class="d-flex a-center">
                            <i class="fa-light fa-sack-dollar"></i>
                            <h3 class="title h3-title">0% Commission</h3>
                        </header>
                        <p>
                            Enjoy the benefit of zero transaction fees on your sales, allowing you to keep more of your
                            hard-earned profits and maximize your revenue. With our platform, you can focus on growing
                            your business without worrying about additional fees eating into your earnings
                        </p>
                    </div>
                    <!-- End Feature -->

                </div>
            </div>
        </section>
        <!-- End Features -->


        <!-- Start Avaiable Sectors -->
        <section class="section">
            <div class="container">
                <h2 class="title main-title t-center">Avaiable Sectors</h2>

                <div class="sectors-wrapper wrapper">
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/grocery.png') }} " alt="">
                        <h3 class="title t-center">Groceries</h3>
                    </div>
                    <!-- End Sector -->
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/library.png') }} " alt="">
                        <h3 class="title t-center">Libraries</h3>
                    </div>
                    <!-- End Sector -->
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/bakery.png ') }} " alt="">
                        <h3 class="title t-center">Bakeries</h3>
                    </div>
                    <!-- End Sector -->
                </div>
            </div>
        </section>
        <!-- End Avaiable Sectors -->
        <!-- Start Avaiable Sectors -->
        <section class="section start-selling--sectors">
            <div class="container">
                <h2 class="title main-title t-center">Coming Soon Sectors</h2>

                <div class="sectors-wrapper wrapper">
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/pharmacy.png ') }} " alt="">
                        <h3 class="title t-center">Pharmacies</h3>
                    </div>
                    <!-- End Sector -->
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/para-pharmacy.png') }}" alt="">
                        <h3 class="title t-center">Para-pharmacies</h3>
                    </div>
                    <!-- End Sector -->
                    <!-- Start Sector -->
                    <div class="sector">
                        <img loading="lazy" src="{{ asset('dist/Assets/butcher-shop.png') }}" alt="">
                        <h3 class="title t-center">Butcheries</h3>
                    </div>
                    <!-- End Sector -->
                </div>
            </div>
        </section>
        <!-- End Avaiable Sectors -->



        <!-- Start Guidelines -->
        <section class="guidelines section">
            <div class="container">
                <h2 class="title main-title t-center">Guidelines</h2>
                <div class=" guidelines-holder">
                    <p>Please Read Our Sectors Guidelines Carefully To Know More About Each Sector's Guidelines</p>
                    <a href="{{ asset('dist/Assets/guidelines.pdf') }}" download="Sectors Guidelines"
                        class="cta-btn ">Download
                        Guidelines</a>
                </div>
            </div>
        </section>
        <!-- End Guidelines -->


        <!-- Start Fees -->
        <section class="section fees">
            <div class="container">
                <h2 class="title main-title t-center">Fees</h2>
                <div class="fees-wrapper wrapper ">

                    <!-- Start Col -->
                    <div class="col">
                        <header>
                            <h3>Subscription</h3>
                            <p class="price"> {{ $fee ? $fee->value : 29 }} DT<small>/Month</small> </p>
                        </header>
                        @if ($fee)
                            {!! $fee->features !!}
                        @else
                            <ul>
                                <li>No Engagment Required</li>
                                <li>Your Store Will be Published all the subscription Period</li>
                                <li>No Hidden Fees</li>
                            </ul>
                        @endif
                    </div>
                    <!-- End Col -->

                </div>
            </div>
        </section>
        <!-- End Fees -->

        <section class="section steps">
            <div class="container">
                <h2 class="title main-title t-center">7 Steps To Join Us</h2>
                <p class="t-center info">swipe left or right To navigate between slides</p>
                <div class="slider slides-wrapper wrapper">
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>1</span>
                            <h3>Create Your Account</h3>
                            <p>
                                With Pickup, setting up your seller account is a breeze. We've streamlined the process
                                to make it as simple and painless as possible, so you can get up and running in just a
                                few minutes.
                            </p>
                        </div>
                        <div class="img-holder">

                            <img loading="lazy" src="{{ asset('dist/Assets/slide-1.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>2</span>
                            <h3>Account Verification</h3>
                            <p>
                                Don't worry, it's a quick and easy process. We'll ask you for a few documents, and once
                                you've submitted them, we'll get back to you in no time.
                            </p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-2.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>3</span>
                            <h3>Store Creation</h3>
                            <p>Our user-friendly platform makes it easy for you to customize your store by adding all
                                the necessary information. With just a few clicks, you'll have your store up and running
                                in no time!</p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-3.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>4</span>
                            <h3>Catalog Setup</h3>
                            <p>with Pickup's user-friendly platform. Adding your products and categories is a
                                simple and straightforward process that won't bore you to tears. <br>

                            </p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-4.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>5</span>
                            <h3>Fund Your Account</h3>
                            <p>

                                In Order to buy publish your store you need to top up your account by purchasing
                                vouchers from our network of point of sales throughout the
                                country. Our platform makes it easy to find a nearby location to purchase the vouchers.
                            </p>
                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-5.svg ') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->

                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>6</span>
                            <h3>Subscription Purchase</h3>
                            <p>Once your store has been approved, it's time to get it up and running with a
                                subscription. Our subscription plans are designed to be flexible, so you can choose the
                                period that suits your needs, from 1 month to 1 year, So Your store will remain
                                published and accessible to customers until the end of your subscription period.

                            </p>

                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-6.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->
                    <!-- Start Slide -->
                    <div class="slide d-flex row">
                        <div class="info">
                            <span>7</span>
                            <h3>Start Earning</h3>
                            <p>"Congratulations, you've made it to the final step! <br> With your store published and
                                accessible to customers, you can now start receiving orders and making money. Get ready
                                to see your business grow and thrive on our platform. Happy selling!" </p>

                        </div>
                        <div class="img-holder">
                            <img loading="lazy" src="{{ asset('dist/Assets/slide-7.svg') }}" alt="">
                        </div>
                    </div>
                    <!-- End Slide -->

                </div>
            </div>
        </section>


        <!-- Start CTA -->
        <section class="section cta">
            <div class="container">
                <div class="cta-wrapper t-center">
                    <p><i class="fa-light fa-shop"></i> {{ $storesCount . ($storesCount == 1 ? ' Store' : ' Stores') }}
                        Already Joined Pickup</p>
                    <h3 class="cta-title">What are you waiting to join us ?</h3>
                    <a href="{{ route('sellerRegister') }}" class="btn cta-btn">Start Selling Now</a>
                </div>
            </div>
        </section>
        <!-- End CTA -->
    </main>
@endsection

@push('scripts')
    <script src="//unpkg.com/a11y-slider@latest/dist/a11y-slider.js"></script>
    <script>
        const slider = new A11YSlider(document.querySelector('.slider'), {
            adaptiveHeight: true,
            dots: false,
            customPaging: function(index, a11ySlider) {
                return '<button class="slider-dots">' + `${index + 1}` + '</button>';
            },
            status: true,
            arrows: false,
            responsive: {
                768: {
                    dots: true,

                },

            }
        });
    </script>
@endpush
