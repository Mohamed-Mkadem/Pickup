@extends('layouts.client-store')

@push('title')
    <title>{{ $store->name }} | Checkout</title>
@endpush

@section('content')
    <section class="content" id="store-holder">
        @if ($store->status == 'unpublished' || $store->status == 'banned')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/404_error.svg') }}" alt="">
                <p class="info-message">This store's subscription has expired, and it is no
                    longer available for browsing or making purchases. It will remain inaccessible until the
                    store owner purchases a new subscription. We apologize for any inconvenience caused. In the
                    meantime, feel free to check out our other active stores for your shopping needs.</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @elseif($store->status == 'maintenance')
            <div class="unavailable-wrapper d-flex col a-center ">
                <img src="{{ asset('dist/Assets/maintenance.svg') }}" alt="">
                <p class="info-message">This store is currently undergoing maintenance to improve your shopping
                    experience. The store owner is working diligently
                    to complete the necessary fixes and updates. Once the maintenance is finished, the store
                    will be published again. Thank you for your patience and understanding</p>
                <div class="buttons d-flex j-sp-between a-center gap-1 wrap mt-1">
                    <a href="{{ url()->previous() }}" class="go-back">Go Back</a>
                    <a href="{{ route('client.shopping') }}" class="shopping">Shopping</a>
                </div>
            </div>
        @else
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')
            @include('components.Stores.client-store-header', ['store' => $store])
            <!-- Start Store Content -->
            <div class="store-content mt-2">
                <div class="results">
                    <h2 class="t-left mb-0-5">Checkout</h2>
                    <p class="abs-error-message mb-0-5">Something went Wrong!</p>
                    <div class="table-responsive checkout-table ">
                        <table>

                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price <span>(DT)</span></th>
                                    <th>Quantity</th>
                                    <th>Total <span>(DT)</span></th>
                                </tr>
                            </thead>
                            <tbody id="cart-tbody">
                                @foreach ($cartProducts as $cartProduct)
                                    <tr>
                                        <td><img src="{{ $cartProduct->image }}" alt=""></td>
                                        <td><a
                                                href="{{ route('client.store.product', ['id' => $cartProduct->product_id, 'username' => $store->username]) }}">{{ ucfirst($cartProduct->name) }}</a>
                                        </td>
                                        <td> {{ number_format($cartProduct->price, 3, ',') }} </td>
                                        <td>{{ $cartProduct->quantity }}</td>
                                        <td class="totalTD">{{ number_format($cartProduct->sub_total, 3, ',') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    <div class="form-control d-flex col a-end ">
                        <p class="cart-total fw-bold mt-1">Total : <span
                                id="total-span">{{ number_format($cart->amount, 3, ',') }}</span>
                            (DT)
                        </p>
                    </div>
                    <div class="buttons d-flex j-end gap-1 wrap mt-1 " id="btns-holder">
                        <a href="{{ route('client.store.cart', $store->username) }}" class="updateBtn">Cart</a>
                        <button class="submitBtn" id="confirmBtn">Confirm </button>

                        <div class="modal-holder">
                            <div class="modal form-modal">
                                <div class="modal-header d-flex j-sp-between a-center">
                                    <h2>Confirm Order</h2>
                                    <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('client.order.place', $store->id) }}" method="POST">
                                        @csrf

                                        <div class="editor-holder pop-up-editor">
                                            <label for="" class="form-label ">Note (To The Seller)</label>
                                            <textarea class="form-element" name="note" id="note" cols="30" rows="10"></textarea>
                                        </div>
                                        <div class="d-flex j-end ">
                                            <button class="submitBtn">Place Order </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Store Content -->
        @endif
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/37.1.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#note'), {
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
    </script>
    <script>
        const confirmBtn = document.getElementById('confirmBtn')
        confirmBtn.addEventListener('click', () => {
            let modalHolder = confirmBtn.nextElementSibling
            modalHolder.classList.add('show')
            document.body.classList.add('no-scroll')
        })
    </script>
@endpush
