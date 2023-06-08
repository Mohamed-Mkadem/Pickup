@extends('layouts.FE')
@push('title')
    <title>Pickup | About</title>
@endpush

@section('content')
<main class="about">
    <!-- Start About Section -->
    <section class="section">
        <div class="container">
            <h1 class="title page-title t-center">About Us</h1>
            <!-- Start  Wrapper -->
            <div class="about-wrapper wrapper d-flex col md-row a-center j-sp-between">
                <div class="info">
                    <h2 class="title  ">Daily Shopping Before Pickup</h2>
                    <p>Before Pickup, daily shopping could be a time-consuming and tedious task. It involved
                        visiting multiple stores, dealing with long queues, and limited product availability.
                        Additionally, customers had to navigate through crowded aisles. With Pickup, say goodbye to
                        these inconveniences and enjoy a streamlined and convenient shopping experience from the
                        comfort of your own home</p>
                </div>
                <div class="img-holder">
                    <img loading="lazy" src="{{ asset('dist/Assets/traditional_shopping.jpg') }}" alt="">
                </div>
            </div>
            <!-- End  Wrapper -->
            <!-- Start  Wrapper -->
            <div class="wrapper about-wrapper d-flex col md-row-reverse a-center j-sp-between">

                <div class="info">
                    <h2 class="title  ">Grocery Shopping With Pickup</h2>
                    <p>With Pickup, daily shopping becomes effortless and efficient. Say goodbye to the hassles of
                        visiting multiple stores, waiting in long queues, and struggling with heavy bags. Enjoy the
                        convenience of shopping from a wide variety of stores, easily finding your desired products,
                        and having them ready for pickup when you need them. Make your daily shopping experience a
                        breeze with Pickup.</p>
                </div>
                <div class="img-holder">
                    <img loading="lazy" src="{{ asset('dist/Assets/pickup-shopping.jpg') }}" alt="">
                </div>
            </div>
            <!-- End  Wrapper -->
        </div>
    </section>
    <!-- End About Section -->


    <!-- Start Team Section -->
    <section class="section team">
        <div class="container">
            <h2 class="title main-title t-center">Meet The Team</h2>
            <div class="team-wrapper">
                <!-- Start Member -->
                <div class="member">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-arthur.jpg') }}" alt="">
                        <h3>Arthur Paul </h3>
                        <span>Founder & CEO </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3>Arthur Paul </h3>
                        <p>“It always amazes me how much talent there is in every corner of the globe.”</p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->
                <!-- Start Member -->
                <div class="member ">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-christian.jpg') }}" alt="">
                        <h3>Cristian Duncan</h3>
                        <span>Founder & CEO </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3>Cristian Duncan</h3>
                        <p>“Distributed teams required unique processes. You need to approach work in a new way.”
                        </p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->
                <!-- Start Member -->
                <div class="member">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-cruz.jpg') }}" alt="">
                        <h3>Cruz Hamer </h3>
                        <span>Founder & CTO </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3>Cruz Hamer </h3>
                        <p>“Technology is at the forefront of enabling distributed teams. That's where we come in.”
                        </p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->
                <!-- Start Member -->
                <div class="member">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-drake.jpg') }}" alt="">
                        <h3>Drake Heaton </h3>
                        <span>Business Development Lead </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3>Drake Heaton </h3>
                        <p>“Hiring similar people from similar backgrounds is a surefire way to stunt innovation.”
                        </p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->
                <!-- Start Member -->
                <div class="member">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-griffin.jpg') }}" alt="">
                        <h3>Griffin Wise </h3>
                        <span>Lead Marketing
                        </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3>Griffin Wise </h3>
                        <p>“Unique perspectives shape unique products, which is what you need to survive these
                            days.”</p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->
                <!-- Start Member -->
                <div class="member">
                    <div class="info">
                        <img loading="lazy" src="{{ asset('dist/Assets/avatar-aden.jpg') }}" alt="">
                        <h3> Aden Allan</h3>
                        <span>Head of Talent </span>
                    </div>
                    <button aria-label="open close back face">

                    </button>
                    <div class="back-face">
                        <h3> Aden Allan </h3>
                        <p>“Empowered teams create truly amazing products. Set the north star and let them follow
                            it.”</p>
                        <ul class="s-m-links">
                            <li><a href=""><i class="fa-brands fa-twitter"></i></a></li>
                            <li><a href=""><i class="fa-brands fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
                <!-- End Member -->






            </div>
        </div>
    </section>
    <!-- End Team Section -->


    <!-- Start Stats Section  -->
    <section class="section">
        <div class="container">
            <h2 class="main-title t-center title">Pickup In Numbers</h2>

            <div class="numbers-wrapper">
                <!-- Start Number -->
                <div class="number">
                    <img loading="lazy" class="m-auto" src=" {{ asset('dist/Assets/store.png') }} " alt="">
                    <p><span class="d-block">1560</span>Stores</p>
                </div>
                <!-- End Number -->
                <!-- Start Number -->
                <div class="number">
                    <img loading="lazy" class="m-auto" src=" {{ asset('dist/Assets/customer.png') }} " alt="">
                    <p><span class="d-block">15060</span>Clients</p>
                </div>
                <!-- End Number -->
                <!-- Start Number -->
                <div class="number">
                    <img loading="lazy" class="m-auto" src=" {{ asset('dist/Assets/orders.png') }} " alt="">
                    <p><span class="d-block">12450</span>Orders</p>
                </div>
                <!-- End Number -->
            </div>
        </div>
    </section>
    <!-- End Stats Section  -->


    <!-- Start CTA -->
    <section class="section cta">
        <div class="container">
            <div class="cta-wrapper t-center">
                <h3 class="cta-title">What are you waiting to join us ?</h3>
                <div class="buttons">
                    <a href="{{ route('startSellingPage') }}" class="btn  cta-btn">Start Selling</a>
                    <a href="{{ route('register') }}" class="btn cta-btn">Start Shopping</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End CTA -->

</main>
@endsection
@push('scripts')
<script>
    buttons = document.querySelectorAll(".member button")
    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            btn.parentElement.classList.toggle("flipped");

        })

    })
</script>
@endpush