@extends('layouts.FE')
@push('title')
    <title>Pickup | Contact</title>
@endpush
@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
@endpush

@section('content')
    <main class="contact">
        <section class="section">
            <div class="container">
                <h2 class="title main-title t-center">Get In Touch</h2>
                @if (session()->has('success'))
                    <div class="alert alert-success  ">
                        <p class="message-body">{{ session()->get('success') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <ul class="alert alert-error ">
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                @endif

                <div class="contact-wrapper">

                    <div class="form-col">
                        <form action="{{ route('contact.send') }}" id="contact-form" method="POST">
                            @csrf
                            <div class="form-row x2">

                                <div class="form-control">
                                    <label for="" class="required">Name : </label>
                                    <input class="form-element" type="text" name="name" id=""
                                        placeholder="Eg: John Doe">
                                    <p class="error " id="nameError"></p>
                                </div>
                                <div class="form-control">
                                    <label for="" class="required">Email Address : </label>
                                    <input class="form-element" type="email" name="email" id=""
                                        placeholder="Eg: JohnDoe@mail.com">

                                    <p class="error " id="emailError"></p>
                                </div>

                            </div>
                            <div class="form-row x1">
                                <div class="form-control">
                                    <label for="" class="required">Subject : </label>
                                    <input class="form-element" type="text" name="subject" id=""
                                        placeholder="Eg: Privacy Policy">

                                    <p class="error " id="subjectError"></p>
                                </div>

                            </div>
                            <div class="form-row x1">
                                <div class="form-control">
                                    <label for="" class="required">Message : </label>
                                    <textarea class="form-element" name="message" placeholder="Your message here" id="" cols="30"
                                        rows="10"></textarea>
                                    <p class="error " id="messageError"></p>
                                </div>
                            </div>
                            <div class="form-row x1">
                                <div class="form-control">
                                    <button type="submit" class="btn">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="map-col" id="map">

                    </div>
                </div>
                <div class="contact-info">
                    <div class="phone">
                        <i class="fa-thin fa-phone"></i>
                        <h3>Let's Talk</h3>
                        <p>+216 50 000 000</p>
                    </div>
                    <div class="Address">
                        <i class="fa-thin fa-map-location-dot"></i>
                        <h3>Our Head Office</h3>
                        <p>Awesome Address - Bab Bhar - Tunis</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script>
        var map = L.map('map').setView([36.848638, 10.227987], 15);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,


        }).addTo(map);
        map.attributionControl.setPrefix('')



        const contactForm = document.getElementById("contact-form");
        const elements = Array.from(document.querySelectorAll('.form-element'))


        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            for (let i = 0; i < elements.length; i++) {
                errorMessage = elements[i].nextElementSibling;
                if (!elements[i].value) {
                    errorMessage.textContent = 'This Field Is required'
                    errorMessage.classList.add('show')
                } else if (elements[i].type == "email") {
                    if (!elements[i].value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)) {
                        errorMessage.textContent = "Please Enter A valid Email Address"
                        errorMessage.classList.add('show')
                    }
                } else {
                    contactForm.submit()
                }
            }
        })
    </script>
@endpush
