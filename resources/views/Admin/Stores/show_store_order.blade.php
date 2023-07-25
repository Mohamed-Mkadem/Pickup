@extends('layouts.Store')

@push('title')
    <title>{{ $store->name }} | Home</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        @include('components.Stores.store-header', ['store' => $store])

        <div class="store-content mt-2">

            <div class="order-holder show-holder">
                <!-- Start Header -->
                <header>
                    <div class="img-holder">
                        <img src="{{ asset('storage/' . $order->store->photo) }}" alt="">
                    </div>
                    <div class="info-holder">
                        <p class=" header-title">
                            Order - <span class=" header-id">#{{ $order->id }}</span>

                            <span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        </p>
                        <div class=" header-details">
                            <div class="detail">
                                <span>Created : </span>
                                <p>{{ $order->created_at->format('M jS Y H:i') }}</p>
                            </div>
                            <div class="detail">
                                <span>Amount (DT) : </span>
                                <p>{{ number_format($order->amount, 3, ',') }}</p>
                            </div>
                            <div class="detail">
                                <span>N° Of Items : </span>
                                <p>{{ $order->no_items }}</p>
                            </div>

                        </div>
                    </div>
                </header>
                <!-- End Header -->


                <!-- Start Order Details Holder -->
                <div class="order-details-holder holder">
                    <h2>Order Details</h2>
                    <div class="table-responsive order-details">
                        <table>

                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price (DT) </th>
                                    <th>Quantity</th>
                                    <th>Total (DT)</th>


                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($products as $product)
                                    <tr>
                                        <td><img src="{{ asset($product->image) }}" alt=""></td>
                                        <td>{{ ucfirst($product->name) }}</td>

                                        <td>{{ number_format($product->price, 3, ',') }}</td>
                                        <td>{{ $product->quantity }}</td>
                                        <td>{{ number_format($product->sub_total, 3, ',') }}</td>

                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                    <!-- Start Pagination -->
                    {!! $products->appends(request()->input())->links() !!}
                    <!-- End Pagination -->
                </div>
                <!-- End Order Details Holder -->

                <!-- Start Order Cards Info-->
                <div class="results-holder holder mt-2 order-details">
                    <!-- Start Card Holder -->
                    <div class="card-holder blueGray-900">
                        <div class="card-title">
                            <h3>Client :</h3>
                        </div>
                        <!-- Start Card -->
                        <div class="card simple  client shadow-none">
                            <header>
                                <p class="status">Status : <span>{{ $order->client->user->status }}</span></p>
                            </header>

                            <div class="info">
                                <img loading="lazy" src="{{ asset('storage/' . $order->client->user->photo) }}"
                                    alt="">
                                <h3> <a
                                        href="{{ route('admin.clients.show', $order->client->user->id) }}">{{ ucfirst($order->client->user->full_name) }}</a>
                                </h3>
                                <p>{{ $order->client->user->state_city }}</p>

                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- Start Card Holder -->
                    <!-- Start Card Holder -->
                    <div class="card-holder teal-200">
                        <div class="card-title">
                            <h3>Store :</h3>
                        </div>
                        <!-- Start Card -->
                        <div class="card simple  store shadow-none">
                            <header class="wrap gap-1">
                                <p>{{ $order->store->state_city }}</p>
                                <p class="rate "><i class="fa-light fa-star"></i> {{ $order->store->rate }}%</p>
                            </header>

                            <div class="info">
                                <img loading="lazy" src="{{ asset('storage/' . $order->store->photo) }}" alt="">
                                <h3><a href={{ route('admin.store.home', $order->store->username) }}>
                                        {{ ucfirst($order->store->name) }} </a>
                                </h3>
                                <p>{{ ucfirst($order->store->sector->name) }}</p>


                            </div>
                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- Start Card Holder -->
                    @if ($order->hasReview())
                        <!-- Start Card Holder -->
                        <div class="card-holder review">
                            <div class="card-title">
                                <h3>Review :</h3>
                            </div>
                            <!-- Start Card -->
                            <div class="card simple  review">
                                <header>
                                    <button class="actions-controller ml-auto"><i
                                            class="fa-solid fa-ellipsis-vertical"></i></button>
                                    <ul class="actions-holder">
                                        <li>
                                            <button class="showBtn">
                                                Show
                                            </button>
                                            <div class="modal-holder ">
                                                <div class="review-box modal">
                                                    <header class="d-flex j-start a-center row">
                                                        <img loading="lazy"
                                                            src="{{ asset('storage/' . $order->client->user->photo) }}"
                                                            alt="">
                                                        <div class="review-info">
                                                            <h3>{{ $order->client->user->full_name }}</h3>
                                                            <p>{{ $order->review->created_at->format('M jS Y H:i') }}</p>
                                                        </div>
                                                        <p class="rate ml-auto"><i class="fa-light fa-star"></i>
                                                            {{ number_format($order->review->total, 1) }}%
                                                        </p>
                                                    </header>
                                                    <p class="review-body">
                                                        @if ($order->review->feedback)
                                                            {!! $order->review->feedback !!}
                                                        @endif
                                                    </p>
                                                    <div class="review-criteria mt-1">
                                                        <div class="criterion">
                                                            <p>- Honesty : </p>
                                                            <div class="points">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <div
                                                                        class="point @if ($i <= $order->review->honesty) checked @endif    ">
                                                                    </div>
                                                                @endfor

                                                            </div>
                                                        </div>
                                                        <div class="criterion">
                                                            <p>- Commitment : </p>
                                                            <div class="points">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <div
                                                                        class="point @if ($i <= $order->review->commitment) checked @endif    ">
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                        <div class="criterion">
                                                            <p>- Hospitality : </p>
                                                            <div class="points">
                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <div
                                                                        class="point @if ($i <= $order->review->hospitality) checked @endif    ">
                                                                    </div>
                                                                @endfor
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <button class="deleteBtn">Remove</button>
                                            <div class="modal-holder ">
                                                <form
                                                    action="{{ route('admin.order.review.destroy', $order->review->id) }}"
                                                    method="post" class="modal t-center confirm-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <i class=" fa-light fa-trash"></i>
                                                    <p>Are You Sure You Want To Delete This Review ?</p>
                                                    <div class="buttons d-flex j-center a-center">
                                                        <button class="cancelBtn">Cancel</button>
                                                        <button class="confirmBtn">Yes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </header>

                                <p class="rate-value" data-rate="{{ $order->review->total }}%">
                                    <span>{{ number_format($order->review->total, 1) }}%</span>
                                </p>

                                <div class="review-criteria">
                                    <div class="criterion">
                                        <p>- Honesty : </p>
                                        <div class="points">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="point @if ($i <= $order->review->honesty) checked @endif    ">
                                                </div>
                                            @endfor

                                        </div>
                                    </div>
                                    <div class="criterion">
                                        <p>- Commitment : </p>
                                        <div class="points">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="point @if ($i <= $order->review->commitment) checked @endif    ">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="criterion">
                                        <p>- Hospitality : </p>
                                        <div class="points">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="point @if ($i <= $order->review->hospitality) checked @endif    ">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- End Card -->
                        </div>
                        <!-- Start Card Holder -->
                    @endif
                </div>
                <!-- End Order Cards Info-->
                <!-- Start order Info Holder -->
                <div class="results-holder p-1 order-info">
                    <div class="radius-10 main-holder notes">
                        <div class="info-title">
                            <h3>Notes</h3>
                        </div>
                        <div class="notes-holder">
                            @if ($order->notes->count() == 0)
                                <h3>This Order Didn't have Any Notes Yet!</h3>
                            @else
                                @foreach ($order->notes as $note)
                                    <div class="note">
                                        <div class="note-header d-flex j-start a-center row gap-1">
                                            @if ($note->notable_type == 'App\Models\Store')
                                                <img loading="lazy" src="{{ asset('storage/' . $note->notable->photo) }}"
                                                    alt="">
                                            @else
                                                <img loading="lazy"
                                                    src="{{ asset('storage/' . $note->notable->user->photo) }}"
                                                    alt="">
                                            @endif
                                            <div class="note-info">
                                                @if ($note->notable_type == 'App\Models\Store')
                                                    <h3>{{ ucfirst($note->notable->name) }}</h3>
                                                @else
                                                    <h3>{{ ucfirst($note->notable->user->full_name) }}</h3>
                                                @endif
                                                <p>{{ $note->created_at->format('M jS Y H:i') }}</p>
                                            </div>
                                        </div>
                                        <p class="note-body">

                                            {!! $note->note !!}
                                        </p>
                                    </div>
                                @endforeach
                            @endif


                        </div>

                    </div>
                    <div class="radius-10  order-history main-holder">
                        <div class="info-title">
                            <h3>Order History</h3>
                        </div>
                        <ul class="statuses">
                            @foreach ($order->statusHistories as $history)
                                <li>
                                    <div class="d-flex row a-start gap-1">
                                        <div class="icon-holder">
                                            @if ($history->action == 'Placed')
                                                <i class="fa-light fa-timer"></i>
                                            @elseif($history->action == 'Accepted')
                                                <i class="fa-light fa-badge-check"></i>
                                            @elseif($history->action == 'Ready')
                                                <i class="fa-light fa-gift"></i>
                                            @elseif($history->action == 'Picked')
                                                <i class="fa-light fa-bag-shopping"></i>
                                            @elseif($history->action == 'Cancelled')
                                                <i class="fa-light fa-rotate-left"></i>
                                            @elseif($history->action == 'Rejected')
                                                <i class="fa-light fa-xmark"></i>
                                            @endif
                                        </div>
                                        <div class="info">
                                            <h4>{{ ucfirst($history->action) }}</h4>
                                            <p>{{ $history->created_at->format('M jS Y H:i') }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach





                        </ul>
                    </div>
                </div>
                <!-- End order Info Holder -->
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const deleteBtns = Array.from(document.querySelectorAll(".deleteBtn"));
        deleteBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                let modalHolder = btn.nextElementSibling;
                modalHolder.classList.add("show");
                document.body.classList.add("no-scroll");
            });
        });
        const showBtns = Array.from(document.querySelectorAll(".showBtn"));
        showBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                let modalHolder = btn.nextElementSibling;
                modalHolder.classList.add("show");
                document.body.classList.add("no-scroll");
            });
        });
    </script>
@endpush
