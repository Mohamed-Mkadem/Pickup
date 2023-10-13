@extends('layouts.Seller')

@push('title')
    <title>Pickup | Product Details</title>
@endpush
@push('light-box')
    <div class="light-box" id="light-box">
        <div class="main-image">
            <button id="close-light-box"><i class="fa-light fa-close"></i></button>
            <img src="{{ asset('storage/' . $product->image) }}" loading="lazy" alt="">
        </div>

    </div>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">
        <!-- Start Show Header -->
        <div class="show-header product-show-header lg d-flex j-start  a-center  col main-holder">
            <div class="img-holder has-overlay">
                <img src="{{ asset('storage/' . $product->image) }}" alt="" id="product-image">
            </div>
            <div class="info-holder">
                <div class="top-header d-flex col j-center a-center">
                    <h2> {{ $product->name }} <small>({{ ucfirst($product->status) }})</small></h2>
                    <ul class="horizontal-actions-holder d-flex j-sp-between a-center">
                        <li>
                            <a href="{{ route('seller.products.edit', $product->id) }}" class="editBtn"> <i
                                    class="fa-light fa-pen"></i>
                                Edit</a>
                        </li>
                        <li>
                            <button class="deleteBtn delete-button">Delete</button>
                            <div class="modal-holder ">
                                <form action="{{ route('seller.products.destroy', $product->id) }}" method="post"
                                    class="modal t-center confirm-form">
                                    @csrf
                                    @method('DELETE')
                                    <i class=" fa-light fa-trash"></i>
                                    <p>Are You Sure You Want To Delete This Product ?</p>
                                    <div class="buttons d-flex j-center a-center">
                                        <button class="cancelBtn">Cancel</button>
                                        <button class="confirmBtn">Yes</button>
                                    </div>
                                </form>
                            </div>
                        </li>

                    </ul>
                </div>
                <div class="details">
                    <p>{{ $product->brand->name }}</p>
                    <p>{{ $product->category->name }}</p>
                    <div class="info-grid lg-4">

                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-warehouse"></i>
                                <h3>Quantity</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $product->quantity }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-file-invoice-dollar"></i>
                                <h3>Cost Price (DT)</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $product->cost_price }} </p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-box-dollar"></i>
                                <h3>Sale Price (DT) </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $product->price }}</p>
                            </div>
                        </div>
                        <!-- End Info -->

                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-stop"></i>
                                <h3>Unit </h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $product->unit }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-warning"></i>
                                <h3>Stock Alert</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ $product->stock_alert }}</p>
                            </div>
                        </div>
                        <!-- End Info -->
                        <!-- Start Info -->
                        <div class="info">
                            <div class="info-title">
                                <i class="fa-light fa-calendar"></i>
                                <h3>Added at</h3>
                            </div>
                            <div class="info-value">
                                <p>{{ \Carbon\Carbon::parse($product->created_at)->format('M jS Y') }} </p>
                            </div>
                        </div>
                        <!-- End Info -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Show Header -->

        <div class="results">
            <div class="results-holder product-details mt-2">
                <div class="product-detail holder radius-10">
                    <div class="top-header buttons">
                        <button class="tabBtn active" data-tab="0">Description</button>
                        <button class="tabBtn" data-tab="1">Info </button>
                        <button class="tabBtn" data-tab="2">Ingredients</button>
                    </div>
                    <div class="tabs detail-body">
                        <div class="tab active">
                            <p>{!! $product->description !!}</p>
                            <button class="modalBtn"></button>
                            <div class="modal-holder">
                                <div class="modal product-modal">
                                    <div class="modal-header mb-1 d-flex j-sp-between a-center">
                                        <h2>Description</h2>

                                        <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                    </div>
                                    <p>{!! $product->description !!}</p>
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

                                        <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                    </div>
                                    @if ($product->info)
                                        <p> {!! $product->info !!}</p>
                                    @else
                                        <p>There Is No Information About This Product</p>
                                    @endif
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

                                        <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                    </div>
                                    @if ($product->ingredients)
                                        <p> {!! $product->ingredients !!}</p>
                                    @else
                                        <p>This Product Doesn't Have Any Ingredients</p>
                                    @endif
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
                            <img src="{{ asset('storage/' . $product->brand->logo) }}" alt="">
                            <h4>{{ $product->brand->name }}</h4>
                        </div>
                        <p> {!! $product->brand->description !!}</p>
                        <button class="modalBtn"></button>
                        <div class="modal-holder">
                            <div class="modal brand-modal">



                                <div class="modal-header d-flex j-sp-between a-center mb-0">
                                    <div class=" brand-header d-flex j-start gap-0-5 a-center">

                                        <img src="{{ asset('storage/' . $product->brand->logo) }}" alt="">
                                        <h4>{{ $product->brand->name }}</h4>
                                    </div>

                                    <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                </div>



                                <p> {!! $product->brand->description !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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
        const lightBox = document.getElementById("light-box");
        // const mainLightBoxImg = lightBox.querySelector(".main-image img");
        const productImage = document.getElementById('product-image')
        productImage.addEventListener('click', () => {
            lightBox.classList.add('show')
            // mainLightBoxImg.src = productImage.src
        })
        const closeLightBoxBtn = document.getElementById("close-light-box");
        closeLightBoxBtn.addEventListener("click", () => {
            lightBox.classList.remove("show");
            document.body.classList.remove("no-scroll");
        });
    </script>
    @include('components.inc_modals-js')
@endpush
