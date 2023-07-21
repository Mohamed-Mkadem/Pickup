@extends('layouts.FE')
@push('title')
    <title>Pickup | Track Order</title>
@endpush

@section('content')
    <main class="track-order">
        <!-- Start Track Order Section -->
        <section class="section">
            <div class="container">
                @include('components.errors-alert')
                @include('components.session-errors-alert')
                @include('components.success-alert')
                <div class="track-wrapper d-flex col md-row ">
                    <div class="col info-holder">
                        <h1 class="main-title title">Track Your Order</h1>
                        <p>You Can Easily Track your Order Using Your Order's ID</p>
                        <ul>
                            <li>The Order's ID is the number You got when you placed your Order</li>
                            <li>You can read more about Orders IDs in the <a target="_blank"
                                    href="{{ route('faqsPage') }}">Faqs
                                    Page</a></li>
                        </ul>
                    </div>
                    <div class="col form-holder">
                        <form action="{{ route('order.get') }}" id="check-form" method="GET">
                            <div class="form-control">
                                <label for="" class="d-block">Enter Check Code</label>
                                <input required type="text" name="order_id" value="{{ request()->order_id }}"
                                    class="form-element">
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

        @if (request()->input('order_id'))
            @if ($order)
                <!-- Start Order Details Section -->
                <section class="section order ">
                    <div class="container">
                        <!-- Start Order Header -->
                        <header>
                            <div class="img-holder"><img loading="lazy"
                                    src=" {{ asset('storage/' . $order->store->photo) }} " alt=""></div>
                            <div class="info-holder">
                                <h3 class="store-name">{{ ucfirst($order->store->name) }}
                                    <span>({{ $order->store->state_city }})</span>
                                </h3>
                                <div class="client-name-date">
                                    @auth
                                        @if (Auth::user()->client == $order->client)
                                            <p class="client-name"> <span>Client :</span>
                                                {{ $order->client->user->full_name . ' (Y fffffffffffffffffff fffffou)' }}
                                            </p>
                                        @else
                                            <p class="client-name"> <span>Client :</span> Anonymous</p>
                                        @endif
                                    @endauth
                                    <p class="date"> <span>Date :</span> {{ $order->created_at->format('M jS Y H:i') }}
                                    </p>
                                </div>
                                <div class="quick-info">
                                    <div class="info status pending">

                                        <div>
                                            <h3>Status</h3>
                                            <p>{{ ucfirst($order->status) }}</p>
                                        </div>

                                        <div><i class="fa-light fa-bag-shopping"></i> </div>
                                    </div>
                                    <div class="info amount">
                                        <div>
                                            <h3>Amount</h3>
                                            <p>{{ number_format($order->amount, 3, ',') }} <small>TND</small></p>

                                        </div>
                                        <div><i class="fa-light fa-dollar-sign"></i> </div>
                                    </div>
                                    <div class="info count">
                                        <div>
                                            <h3>N° Items</h3>
                                            <p>{{ $order->no_items }}</p>

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
                                        @foreach ($products as $product)
                                            <tr>
                                                <td><img loading="lazy" src=" {{ asset($product->image) }} "
                                                        alt=""></td>
                                                <td>{{ ucfirst($product->name) }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ number_format($product->price, 3, ',') }}</td>
                                                <td>{{ number_format($product->sub_total, 3, ',') }}</td>

                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Order Products -->

                    </div>
                </section>
                <!-- End Order Details Section -->
            @else
                <!-- Start Not Found  -->
                <div class="not-found-wrapper show">
                    <i class="fa-light fa-circle-info"></i>
                    <h3>Not Found</h3>
                    <p>There is no order with the ID you entered </p>
                    <p>Please Make sure you entered It correctly </p>
                </div>
                <!-- End Not Found  -->
            @endif
        @endif
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
            else {

                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                checkForm.submit();
            }
        })
    </script>
@endpush
