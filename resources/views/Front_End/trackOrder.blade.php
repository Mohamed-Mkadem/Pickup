@extends('layouts.FE')
@push('title')
<title>Pickup | Track Order</title>
@endpush

@section('content')
<main class="track-order">
    <!-- Start Track Order Section -->
    <section class="section">
        <div class="container">
            <div class="track-wrapper d-flex col md-row ">
                <div class="col info-holder">
                    <h1 class="main-title title">Track Your Order</h1>
                    <p>You Can Easily Track your Order Using Your Order's Check Code</p>
                    <ul>
                        <li>The Order's Check Code is the code You got when you placed your Order</li>
                        <li>Please don't share this code with someone you don't trust</li>
                        <li>You can read more about check codes in the <a target="_blank" href="{{ route('faqsPage') }}">Faqs
                                Page</a></li>
                    </ul>
                </div>
                <div class="col form-holder">
                    <form action="" id="check-form" method="GET">
                        <div class="form-control">
                            <label for="" class="d-block">Enter Check Code</label>
                            <input required type="text" name="" class="form-element">
                            <p class="error-message ">This Field Is required</p>
                        </div>
                        <div class="form-control">
                            <button type="submit">Check</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End Track Order Section -->


    <!-- Start Order Details Section -->
    <section class="section order ">
        <div class="container">
            <!-- Start Order Header -->
            <header>
                <div class="img-holder"><img loading="lazy" src=" {{ asset('dist/Assets/avatar-arthur.jpg') }} " alt=""></div>
                <div class="info-holder">
                    <h3 class="store-name">Magico Store <span>(Ariana - Mnihla)</span></h3>
                    <div class="client-name-date">
                        <p class="client-name"> <span>Client :</span> Mohamed Mkadem</p>
                        <p class="date"> <span>Date :</span> 4/17/2023 / 17:29</p>
                    </div>
                    <div class="quick-info">
                        <div class="info status pending">

                            <div>
                                <h3>Status</h3>
                                <p>Picked</p>
                            </div>

                            <div><i class="fa-light fa-bag-shopping"></i> </div>
                        </div>
                        <div class="info amount">
                            <div>
                                <h3>Amount</h3>
                                <p>220 <small>TND</small></p>

                            </div>
                            <div><i class="fa-light fa-dollar-sign"></i> </div>
                        </div>
                        <div class="info count">
                            <div>
                                <h3>N° Items</h3>
                                <p>17 Items</p>

                            </div>
                            <div><i class="fa-light fa-cart-shopping"></i> </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- End Order Header -->
            <!-- Start Order Products -->
            <div class="order-products">
                <h3 class="t-left">Products</h3>

                <div class="table-responsive">
                    <table>

                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price <span>(DT)</span></th>
                                <th>Total <span>(DT)</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img loading="lazy" src=" {{ asset('dist/Assets/avatar-aden.jpg') }} " alt=""></td>
                                <td>Mohamed Mkadem</td>
                                <td>2</td>
                                <td>25</td>
                                <td>254.3</td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Order Products -->
            <!-- Start Order Details -->
            <div class="order-details d-flex col md-row">
                <div class="col notes">
                    <h3>Notes</h3>
                    <div class="client-note note">
                        <h4>Client's Notes</h4>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere magnam veritatis
                            eligendi at corrupti voluptate cum dicta similique. Neque rem dicta ea ratione nesciunt
                            qui ipsum! Inventore asperiores eum at.</p>
                    </div>
                    <div class="seller-note note">
                        <h4>Seller's Notes</h4>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Facere magnam veritatis
                            eligendi at corrupti voluptate cum dicta similique. Neque rem dicta ea ratione nesciunt
                            qui ipsum! Inventore asperiores eum at.</p>
                    </div>
                </div>
                <div class="col order-history">
                    <h3>Order History</h3>
                    <ul class="status">
                        <li>
                            <div class="d-flex row a-start">
                                <div class="icon-holder">
                                    <i class="fa-light fa-timer"></i>
                                </div>
                                <div class="info">
                                    <h4>Placed</h4>
                                    <p>Monday, Aptil 17th 2023 17:35</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex row a-start">
                                <div class="icon-holder">
                                    <i class="fa-light fa-timer"></i>
                                </div>
                                <div class="info">
                                    <h4>Placed</h4>
                                    <p>Monday, Aptil 17th 2023 17:35</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex row a-start">
                                <div class="icon-holder">
                                    <i class="fa-light fa-timer"></i>
                                </div>
                                <div class="info">
                                    <h4>Placed</h4>
                                    <p>Monday, Aptil 17th 2023 17:35</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex row a-start">
                                <div class="icon-holder">
                                    <i class="fa-light fa-timer"></i>
                                </div>
                                <div class="info">
                                    <h4>Placed</h4>
                                    <p>Monday, Aptil 17th 2023 17:35</p>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            <!-- End Order Details -->
        </div>
    </section>
    <!-- End Order Details Section -->
    <!-- Start Not Found  -->
    <div class="not-found-wrapper ">
        <i class="fa-light fa-circle-info"></i>
        <h3>Not Found</h3>
        <p>There is no order with the check code you entered </p>
        <p>Please Make sure you entered It correctly </p>
    </div>
    <!-- End Not Found  -->

</main>

@endsection

@push('scripts')
<script>
    const checkForm = document.getElementById('check-form')

    const checkCodeInput = document.querySelector('.form-element')

    const errorMessage = checkCodeInput.nextElementSibling;
    checkForm.addEventListener('submit', (e) => {
        e.preventDefault();
        if (checkCodeInput.value == '') {
            errorMessage.textContent = 'This Field Is Required'
            errorMessage.classList.add('show')
        }
        // In case that I will make the check code only numbers I'll use this condition to valid
        // else if (!checkCodeInput.value.match(/^[0-9]*$/)) {
        //     errorMessage.textContent = 'Enter A valid Check Code'
        //     errorMessage.classList.add('show')

        // }
    })

</script>
@endpush