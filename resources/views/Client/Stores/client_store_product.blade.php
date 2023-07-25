@extends('layouts.client-store')

@push('title')
    <title>{{ $store->name }} | {{ $product->name }}</title>
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
                    <div class=" product-row holder radius-10">

                        <div class=" p-1 img-holder radius-10">
                            <img src="{{ asset('storage/' . $product->image) }}" width="400px" alt="">
                        </div>
                        <div class=" p-1 product-info radius-10">
                            <p class="category-name">{{ $product->category->name }}</p>
                            <h1 class="product-name">{{ $product->name }}</h1>
                            <p class="brand-name">{{ $product->brand->name }}</p>
                            <p class="stock p-span">Stock : <span>{{ $product->quantity }}</span></p>
                            <p class="price-unit">{{ number_format($product->price, 3, ',') }} <small>DT</small>
                                @if ($product->unit == 'liquid')
                                    <span>(1 Liter)</span>
                                @elseif($product->unit == 'weight')
                                    <span>(1 KG)</span>
                                @else
                                    <span>(1 Piece)</span>
                                @endif
                            </p>

                            <form action="{{ route('client.cart.add', $store->id) }}" method="post" class="cart-actions">
                                <div class="quantity-holder  ">

                                    <button id="minus">-</button>
                                    <input type="number" name="quantity" id="quantity" readonly value="1" />
                                    <button id="plus">+</button>
                                </div>
                                <div class="hidden-inputs">

                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="image" value="{{ asset('storage/' . $product->image) }}">
                                    <button type="submit"><i class="fa-light fa-cart-shopping"></i><span> Add To
                                            Cart</span></button>
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="results-holder product-details mt-2">
                        <div class="product-detail holder radius-10">
                            <div class="top-header buttons">
                                <button class="tabBtn active" data-tab="0">Description</button>
                                <button class="tabBtn" data-tab="1">Info </button>
                                <button class="tabBtn" data-tab="2">Ingredients</button>
                            </div>
                            <div class="tabs detail-body">
                                <div class="tab active">
                                    <p> {!! $product->description !!}</p>
                                    <button class="modalBtn"></button>
                                    <div class="modal-holder">
                                        <div class="modal product-modal">
                                            <div class="modal-header mb-1 d-flex j-sp-between a-center">
                                                <h2>Description</h2>

                                                <button class="close-modal-holder-btn"><i
                                                        class="fa-light fa-close"></i></button>
                                            </div>
                                            <p> {!! $product->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab">
                                    @if ($product->info)
                                        <p> {!! $product->info !!}</p>
                                    @else
                                        <p>There Is No Information About This Product</p>
                                    @endif
                                    <button class="modalBtn"></button>
                                    <div class="modal-holder">
                                        <div class="modal product-modal">
                                            <div class="modal-header mb-1 d-flex j-sp-between a-center">
                                                <h2>Info</h2>

                                                <button class="close-modal-holder-btn"><i
                                                        class="fa-light fa-close"></i></button>
                                            </div>
                                            <p>
                                                @if ($product->info)
                                                    <p> {!! $product->info !!}</p>
                                                @else
                                                    <p>There Is No Information About This Product</p>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab">
                                    @if ($product->ingredients)
                                        <p> {!! $product->ingredients !!}</p>
                                    @else
                                        <p>This Product Doesn't Have Any Ingredients</p>
                                    @endif
                                    <button class="modalBtn"></button>
                                    <div class="modal-holder">
                                        <div class="modal product-modal">
                                            <div class="modal-header mb-1 d-flex j-sp-between a-center">
                                                <h2>Ingredients</h2>

                                                <button class="close-modal-holder-btn"><i
                                                        class="fa-light fa-close"></i></button>
                                            </div>
                                            <p>
                                                @if ($product->ingredients)
                                                    <p> {!! $product->ingredients !!}</p>
                                                @else
                                                    <p>This Product Doesn't Have Any Ingredients</p>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="product-detail holder radius-10">
                            <div class="top-header ">
                                <h3>About Brand</h3>

                            </div>
                            <div class="detail-body about-brand">
                                <div class=" brand-header d-flex j-start gap-0-5 a-center">
                                    {{-- <img src="{{ asset('storage/' . $product->brand->logo) }}" alt=""> --}}
                                    <img src="{{ $product->brand->logo }}" alt="">
                                    <h4>{{ $product->brand->name }}</h4>
                                </div>

                                @if ($product->brand->description)
                                    <p> {!! $product->brand->description !!}</p>
                                @else
                                    <p>This Brand Doesn't Have Any Description</p>
                                @endif

                                <button class="modalBtn"></button>
                                <div class="modal-holder">
                                    <div class="modal brand-modal">



                                        <div class="modal-header d-flex j-sp-between a-center mb-0">
                                            <div class=" brand-header d-flex j-start gap-0-5 a-center">

                                                <img src="{{ $product->brand->logo }}" alt="">
                                                {{-- <img src="{{ asset('storage/' . $product->brand->logo) }}" alt=""> --}}
                                                <h4>{{ $product->brand->name }}</h4>
                                            </div>

                                            <button class="close-modal-holder-btn"><i
                                                    class="fa-light fa-close"></i></button>
                                        </div>


                                        @if ($product->brand->description)
                                            <p> {!! $product->brand->description !!}</p>
                                        @else
                                            <p>This Brand Doesn't Have Any Description</p>
                                        @endif
                                    </div>
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
    <script>
        const minusBtn = document.getElementById("minus");
        const plusBtn = document.getElementById("plus");
        const quantity = document.getElementById("quantity");

        minusBtn.addEventListener("click", (e) => {
            e.preventDefault()
            if (quantity.value > 1) {
                quantity.value = parseInt(quantity.value) - 1;
            }
        });
        plusBtn.addEventListener("click", (e) => {
            e.preventDefault()
            if (quantity.value < 99) {
                quantity.value = parseInt(quantity.value) + 1;
            }
        });


        const tabBtns = Array.from(document.querySelectorAll('.tabBtn'))
        const tabs = Array.from(document.querySelectorAll('.tab'))
        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                tabBtns.forEach(btn => {
                    btn.classList.remove('active')
                })
                btn.classList.add('active')
                tabs.forEach(tab => {
                    tab.classList.remove('active')
                })
                tabs[btn.dataset.tab].classList.add('active')

            })
        })
        const modalBtns = Array.from(document.querySelectorAll('.modalBtn'))
        modalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                let modalHolder = btn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })
        })
    </script>
@endpush
