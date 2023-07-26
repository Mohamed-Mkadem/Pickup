@extends('layouts.Seller')

@push('title')
    <title>Pickup | Order Details</title>
@endpush
@section('content')
    <section class="content" id="content">


        @if ($order->status == 'pending')
            <ul class="horizontal-actions-holder  d-flex gap-1 mb-2 wrap j-center a-center">

                <li>
                    <button class="deleteBtn delete-button">Reject</button>

                    <div class="modal-holder ">
                        <form action="{{ route('seller.orders.reject', $order->id) }}" method="post" id="reject-form"
                            class="modal order-modal t-center ">
                            @csrf
                            @method('PATCH')
                            <div class="modal-header d-flex j-sp-between a-center">
                                <h2>Reject Order </h2>
                                <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                            </div>
                            <div class="editor-holder pop-up-editor">
                                <label for="" class="form-label ">Notes (To The Client)</label>
                                <textarea name="note" class="form-element" id="reject-description" cols="30" rows="10"></textarea>
                            </div>
                            <div class="buttons d-flex j-end ">
                                <button class="delete-button">Reject</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <button class="activateBtn activate-button">Accept</button>
                    <div class="modal-holder ">
                        <div class="modal t-center order-modal">
                            <div class="modal-header d-flex j-sp-between a-center">
                                <h2>Accept Order </h2>
                                <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                            </div>
                            <form action="{{ route('seller.orders.accept', $order->id) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <div class="editor-holder pop-up-editor">
                                    <label for="" class="form-label ">Notes (To The Client)</label>
                                    <textarea name="note" class="form-element" id="accept-description" cols="30" rows="10"></textarea>
                                </div>
                                <div class="buttons d-flex j-end ">
                                    <button class=" activate-button">Accept</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        @elseif($order->status == 'accepted')
            <ul class="horizontal-actions-holder  d-flex gap-1 mb-2 wrap j-center a-center">
                <li>
                    <button class="deleteBtn delete-button">Cancel</button>

                    <div class="modal-holder ">
                        <form action="{{ route('seller.orders.cancel', $order->id) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('PATCH')
                            <i class=" fa-light fa-info"></i>

                            <p class=" d-block fw-bold mb-0-5 mt-1">This Action Will Cost You
                                {{ ($order->amount / 100) * 10 }} DT</p>
                            <p class="mt-0">Are You Sure You Want To Cancel This Order ? </p>

                            <div class="buttons d-flex j-center a-center">
                                <button class="cancelBtn">Cancel</button>
                                <button class="confirmBtn">Yes</button>
                            </div>
                        </form>
                    </div>
                </li>
                <li>
                    <button class="deleteBtn activate-button">Mark As Ready</button>

                    <div class="modal-holder ">
                        <form action="{{ route('seller.orders.ready', $order->id) }}" method="post"
                            class="modal t-center confirm-form">
                            @csrf
                            @method('PATCH')
                            <i class=" fa-light fa-info"></i>
                            <p>Are You Sure You Want To Mark This Order As Ready ? </p>

                            <div class="buttons d-flex j-center a-center">
                                <button class="cancelBtn">Cancel</button>
                                <button class="activate-button">Yes</button>
                            </div>
                        </form>
                    </div>
                </li>

            </ul>
        @elseif($order->status == 'ready')
            @if ($order->hasPendingPickRequest())
                <p class="t-center mb-2 pick-request-message">A Pick Request Has Been Sent On :
                    {{ $order->pickRequests()->latest()->first()->created_at->format('M jS Y H:i') }}</p>
            @else
                <ul class="horizontal-actions-holder  d-flex gap-1 mb-2 wrap j-center a-center">
                    <li>
                        <button class="deleteBtn delete-button">Cancel</button>

                        <div class="modal-holder ">
                            <form action="{{ route('seller.orders.cancel', $order->id) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')

                                <i class=" fa-light fa-info"></i>
                                <p class=" d-block fw-bold mb-0-5 mt-1">This Action Will Cost You
                                    {{ ($order->amount / 100) * 20 }}DT</p>
                                <p class="mt-0">Are You Sure You Want To Cancel This Order ? </p>

                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="confirmBtn">Yes</button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <button class="deleteBtn activate-button">Send A Pick Request</button>

                        <div class="modal-holder ">
                            <form action="{{ route('seller.pickRequest.store') }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                <input type="hidden" name="order_id" value="{{ $order->id }}">
                                <i class=" fa-light fa-info"></i>
                                <p>Are You Sure You Want To Send A Pick Request For This Order ? </p>

                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="activate-button">Yes</button>
                                </div>
                            </form>
                        </div>
                    </li>

                </ul>
            @endif
        @endif


        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <div class="order-holder show-holder">
            <!-- Start Header -->
            <header>
                <div class="img-holder">
                    <img loading="lazy" src="{{ asset('storage/' . $order->client->user->photo) }}" alt="">
                </div>
                <div class="info-holder">
                    <p class=" header-title">
                        Order - <span class=" header-id">#{{ $order->id }}</span>

                        <span
                            class="status  {{ $order->status }}
                         ">{{ ucfirst($order->status) }}</span>
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
                                    <td><a
                                            href="{{ route('seller.products.show', $product->product_id) }}">{{ ucfirst($product->name) }}</a>
                                    </td>
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
                            <h3>{{ ucfirst($order->client->user->full_name) }}</h3>
                            <p>{{ $order->client->user->state_city }}</p>

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
                                                        <h3>{{ $order->review->client->user->full_name }}</h3>
                                                        <p>{{ $order->review->created_at->format('M jS Y H:i') }}</p>
                                                    </div>
                                                    <p class="rate ml-auto"><i class="fa-light fa-star"></i>
                                                        {{ number_format($order->review->total, 1) }}%
                                                    </p>
                                                </header>
                                                <div class="review-body">
                                                    {!! $order->review->feedback !!}
                                                </div>
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
                                    <div class="note-body">

                                        {!! $note->note !!}
                                    </div>
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
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        const rejectDescription = document.getElementById('reject-description')
        if (rejectDescription) {

            ClassicEditor
                .create(document.querySelector('#reject-description'), {
                    toolbar: ['heading', '|', 'bold'],
                })
                // .then(editor => {
                //     editor.model.document.on('change:data', () => {
                //         editorData = editor.getData();
                //         console.log(editorData);
                //     });
                // })

                .catch(error => {
                    console.error(error);
                });
        }
        const acceptDescription = document.getElementById('accept-description')
        if (acceptDescription) {

            ClassicEditor
                .create(document.querySelector('#accept-description'), {
                    toolbar: ['heading', '|', 'bold'],
                })
                // .then(editor => {
                //     editor.model.document.on('change:data', () => {
                //         editorData = editor.getData();
                //         console.log(editorData);
                //     });
                // })

                .catch(error => {
                    console.error(error);
                });
        }
    </script>
    @include('components.inc_modals-js')
@endpush
