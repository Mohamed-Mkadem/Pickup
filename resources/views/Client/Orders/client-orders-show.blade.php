@extends('layouts.Client')

@push('title')
    <title>Pickup | Order Details</title>
@endpush


@section('content')
    <section class="content" id="content">
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <ul class="horizontal-actions-holder  d-flex gap-1 mb-2 wrap j-center a-center">
            @if (!in_array($order->status, ['picked', 'cancelled', 'rejected']))
                @if ($order->hasPendingPickRequest())
                    <li>
                        <button class="deleteBtn delete-button">Refuse The Pickup </button>

                        <div class="modal-holder ">
                            <form
                                action="{{ route('client.pickRequest.refuse',$order->pickRequests()->latest()->first()->id) }}"
                                method="post" class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-light fa-info"></i>
                                <p>Are You Sure You Want To Refuse the pickup of this Order ? </p>

                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="delete-button">Yes</button>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li>
                        <button class="deleteBtn activate-button">Confirm The Pickup </button>

                        <div class="modal-holder ">
                            <form
                                action="{{ route('client.pickRequest.confirm',$order->pickRequests()->latest()->first()->id) }}"
                                method="post" class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-light fa-info"></i>
                                <p>Are You Sure You Want To Confirm the pickup of this Order ? </p>

                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="activate-button">Yes</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @else
                    <li>
                        <button class="deleteBtn delete-button">Cancel</button>

                        <div class="modal-holder ">
                            <form action="{{ route('client.order.cancel', $order->id) }}" method="post"
                                class="modal t-center confirm-form">
                                @csrf
                                @method('PATCH')
                                <i class=" fa-light fa-info"></i>

                                @if ($order->status == 'accepted')
                                    <p class="  fw-bold mb-0-5 mt-1">This Action Will Cost You
                                        {{ ($order->amount / 100) * 10 }}DT </p>
                                @elseif($order->status == 'ready')
                                    <p class="  fw-bold mb-0-5 mt-1">This Action Will Cost You
                                        {{ ($order->amount / 100) * 20 }}DT </p>
                                @else
                                    <p class="  fw-bold mb-0-5 mt-1">This Action Will Cost You
                                        0 DT </p>
                                @endif

                                <p class="mt-0">Are You Sure You Want To Cancel This Order ? </p>

                                <div class="buttons d-flex j-center a-center">
                                    <button class="cancelBtn">Cancel</button>
                                    <button class="confirmBtn">Yes</button>
                                </div>
                            </form>
                        </div>
                    </li>
                @endif
            @endif
            {{-- If Order Has Pickup Request --}}
            {{-- <li>
                <button class="deleteBtn activate-button">Confirm The Pickup </button>

                <div class="modal-holder ">
                    <form action="" method="post" class="modal t-center confirm-form">
                        <i class=" fa-light fa-info"></i>
                        <p>Are You Sure You Want To Confirm the pickup of this Order ? </p>

                        <div class="buttons d-flex j-center a-center">
                            <button class="cancelBtn">Cancel</button>
                            <button class="activate-button">Yes</button>
                        </div>
                    </form>
                </div>
            </li> --}}
            {{-- If Order Has Pickup Request --}}
        </ul>


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
                                    <td><a
                                            href="{{ route('client.store.product', ['id' => $product->product_id, 'username' => $order->store->username]) }}">{{ ucfirst($product->name) }}</a>
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
                <div class="card-holder teal-200">
                    <div class="card-title">
                        <h3>Store :</h3>
                    </div>
                    <!-- Start Store -->
                    <div class="card simple  store shadow-none">
                        <header class="wrap gap-1">
                            <p>{{ $order->store->state_city }}</p>
                            <p class="rate "><i class="fa-light fa-star"></i> {{ $order->store->rate }}%</p>
                        </header>

                        <div class="info">
                            <img loading="lazy" src="{{ asset('storage/' . $order->store->photo) }}" alt="">
                            <h3><a href={{ route('client.store.home', $order->store->username) }}>
                                    {{ ucfirst($order->store->name) }} </a>
                            </h3>
                            <p>{{ ucfirst($order->store->sector->name) }}</p>


                        </div>
                    </div>
                    <!-- End Store -->
                </div>
                <!-- Start Card Holder -->
                @if ($order->hasReview())
                    <!-- Start Card Holder -->
                    <div class="card-holder review ">
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
                                        <button class="editBtn">Edit</button>
                                        <div class="modal-holder ">
                                            <div class="modal form-modal">
                                                <div class="modal-header d-flex j-sp-between a-center">
                                                    <h2>Edit Review</h2>
                                                    <button class="close-modal-holder-btn"><i
                                                            class="fa-light fa-close"></i></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('client.order.review.update', $order->review->id) }}"
                                                        method="post" id="edit-form">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="form-control">
                                                            <label for="" class="form-label  ">Honesty</label>
                                                            <input type="text" class="form-element" readonly
                                                                value="5 Stars">

                                                        </div>
                                                        <div class="form-control">
                                                            <label for="" class="form-label ">Commitment</label>
                                                            <input type="text" class="form-element" readonly
                                                                value="4 Stars">
                                                        </div>
                                                        <div class="form-control">
                                                            <label for="" class="form-label ">Hospitality</label>
                                                            <input type="text" class="form-element" readonly
                                                                value="4 Stars">
                                                        </div>
                                                        <div class="editor-holder pop-up-editor">
                                                            <label for="" class="form-label ">Feedback (Max 120
                                                                Characters)</label>
                                                            <textarea name="feedback" id="edit-review-feedback" cols="30" rows="10">{!! $order->review->feedback !!}</textarea>
                                                            <p class="error-message" id="review-feedback-error-message">
                                                                This Field
                                                                Is Required
                                                            </p>
                                                        </div>
                                                        <div class="form-control">
                                                            <div class="d-flex j-start a-start gap-1 ">
                                                                <input type="checkbox" class="reset" name="anonymous"
                                                                    id="anonymous"
                                                                    @if ($order->review->anonymous) checked @endif>
                                                                <label for="anonymous"
                                                                    style="margin-bottom: 0; margin-top: -5px; cursor: pointer;"
                                                                    class="form-label">Review
                                                                    Anonymously (Only The Seller And The Administration can
                                                                    see
                                                                    who you
                                                                    are)</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-control d-flex j-end">
                                                            <button type="submit" class="submitBtn">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
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
                                                <div class="review-body ">
                                                    @if ($order->review->feedback)
                                                        {!! $order->review->feedback !!}
                                                    @endif
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
                    <!-- End Card Holder -->
                @endif
                @if (!$order->hasReview() && $order->status == 'picked')
                    <!-- Start Card Holder -->
                    <div class="card-holder review ">
                        <div class="card-title">
                            <h3>Review :</h3>
                        </div>
                        <!-- Start Card -->
                        <div class="card simple  review addBox">
                            <div class="btn-wrapper h-100 d-flex j-center a-center">
                                <button id="addReview" aria-label="Add Review">+</button>
                                <div class="modal-holder ">
                                    <div class="modal form-modal">
                                        <div class="modal-header d-flex j-sp-between a-center">
                                            <h2>Add Review</h2>
                                            <button class="close-modal-holder-btn"><i
                                                    class="fa-light fa-close"></i></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('client.order.review', $order->id) }}" method="post"
                                                id="review-form">
                                                <div class="form-control">
                                                    @csrf
                                                    <label for="" class="form-label">How Did You Find This Store
                                                        ?</label>
                                                </div>
                                                <div class="form-control">
                                                    <label for="" class="form-label required ">Honesty</label>
                                                    <div class="select-box">
                                                        <select name="honesty" class="form-element">

                                                            <option value="1">1 Star</option>
                                                            <option value="2">2 Stars</option>
                                                            <option value="3">3 Stars</option>
                                                            <option value="4">4 Stars</option>
                                                            <option value="5">5 Stars</option>
                                                        </select>
                                                    </div>
                                                    <p class="error-message">This Field Is Required</p>
                                                </div>
                                                <div class="form-control">
                                                    <label for="" class="form-label required">Commitment</label>
                                                    <div class="select-box">
                                                        <select name="commitment" class="form-element">

                                                            <option value="1">1 Star</option>
                                                            <option value="2">2 Stars</option>
                                                            <option value="3">3 Stars</option>
                                                            <option value="4">4 Stars</option>
                                                            <option value="5">5 Stars</option>
                                                        </select>
                                                    </div>
                                                    <p class="error-message">This Field Is Required</p>
                                                </div>
                                                <div class="form-control">
                                                    <label for="" class="form-label required">Hospitality</label>
                                                    <div class="select-box">
                                                        <select name="hospitality" class="form-element">

                                                            <option value="1">1 Star</option>
                                                            <option value="2">2 Stars</option>
                                                            <option value="3">3 Stars</option>
                                                            <option value="4">4 Stars</option>
                                                            <option value="5">5 Stars</option>
                                                        </select>
                                                    </div>
                                                    <p class="error-message">This Field Is Required</p>
                                                </div>
                                                <div class="editor-holder pop-up-editor">
                                                    <label for="" class="form-label ">Feedback (Max 120
                                                        Characters)</label>
                                                    <textarea name="feedback" id="review-feedback" cols="30" rows="10">{{ old('feedback') }}</textarea>
                                                    <p class="error-message" id="review-feedback-error-message">
                                                        This Field
                                                        Is Required
                                                    </p>
                                                </div>
                                                <div class="form-control">
                                                    <div class="d-flex j-start a-start gap-1 ">
                                                        <input type="checkbox" class="reset" name="anonymous"
                                                            id="anonymous-review">
                                                        <label for="anonymous-review"
                                                            style="margin-bottom: 0; margin-top: -5px; cursor: pointer;"
                                                            class="form-label">Review
                                                            Anonymously (Only The Seller And The Administration can see who
                                                            you
                                                            are)</label>
                                                    </div>
                                                </div>
                                                <div class="form-control d-flex j-end">
                                                    <button type="submit" class="submitBtn">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- End Card -->
                    </div>
                    <!-- End Card Holder -->
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

    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>

    <script>
        const newReview = document.getElementById('review-feedback');
        if (newReview) {


            ClassicEditor
                .create(document.querySelector('#review-feedback'), {
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
            const addReviewBtn = document.getElementById('addReview')

            addReviewBtn.addEventListener('click', () => {
                let modalHolder = addReviewBtn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })

            const honestySelect = document.querySelector('select[name=honesty]')
            const commitmentSelect = document.querySelector('select[name=commitment]')

            const hospitalitySelect = document.querySelector('select[name=hospitality]')
            const reviewForm = document.getElementById('review-form')
            reviewForm.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                errors += validateField(honestySelect, honestySelect.parentElement.nextElementSibling)
                errors += validateField(commitmentSelect, commitmentSelect.parentElement.nextElementSibling)
                errors += validateField(hospitalitySelect, hospitalitySelect.parentElement.nextElementSibling)
                if (!errors) reviewForm.submit()
            })

            function validateField(field, errorMessage) {
                let errors = 0
                if (!field.value) {
                    errorMessage.textContent = 'This Field Is Required'
                    errorMessage.classList.add('show')
                    errors = 1
                } else {
                    errorMessage.textContent = ''
                    errorMessage.classList.remove('show')
                    errors = 0
                }
                return errors
            }
        }
        const editReview = document.getElementById('edit-review-feedback');
        if (editReview) {

            ClassicEditor
                .create(document.querySelector('#edit-review-feedback'), {
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
