@extends('layouts.Admin')

@push('title')
    <title>Pickup | Vouchers </title>
@endpush

@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Vouchers</h1>
            <div class="buttons-holder d-flex j-center a-center">
                <a href="{{ route('admin.vouchers.create') }}" class="add-btn header-btn"> <i class="fa-light fa-plus"></i> Add
                    Vouchers
                </a>

            </div>
        </div>
        <!-- End Starter Header -->


        <!-- Start Filters -->
        <div class="filters-holder">
            <div class="filters-header d-flex j-sp-between a-center">
                <h2>Filters</h2>
                <button id="filters-wrapper-controller" aria-controls="#filters-wrapper"><i
                        class="fa-light fa-circle-caret-down"></i></button>
            </div>
            <div class="filters-wrapper" id="filters-wrapper">
                <form action="{{ route('admin.vouchers.filter') }}" method="GET">
                    <div class="filter-row row3">

                        <div class="filter-box">
                            <label for="" class="form-label">Category</label>
                            <div class="select-box">
                                <select name="category_id" class="form-element">

                                    <option value="all" {{ 'all' == request()->input('category_id') ? 'selected' : '' }}>
                                        All</option>
                                    @foreach ($vouchersCategories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id == request()->input('category_id') ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">Sort By</label>
                            <div class="select-box">
                                <select name="sort" class="form-element">
                                    <option value="newest" {{ request()->sort == 'newest' ? 'selected' : '' }}>Newest
                                    </option>
                                    <option value="oldest" {{ request()->sort == 'oldest' ? 'selected' : '' }}>Oldest
                                    </option>
                                    <option value="highest" {{ request()->sort == 'highest' ? 'selected' : '' }}>Highest
                                        Value</option>
                                    <option value="lowest" {{ request()->sort == 'lowest' ? 'selected' : '' }}>Lowest Value
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="filter-box">
                            <label for="" class="form-label">Status </label>
                            <div class="choices-btns-wrapper  ">
                                <div class="choice-btn form-element">
                                    <label for="used-input"> used</label>
                                    <input type="checkbox"
                                        {{ in_array('used', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="used-input" name="status[]" value="used">
                                </div>
                                <div class="choice-btn form-element">
                                    <label for="unused-input">unused</label>
                                    <input type="checkbox"
                                        {{ in_array('unused', (array) request()->input('status')) ? 'checked' : '' }}
                                        id="unused-input" name="status[]" value="unused">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-row row2">
                        <div class="filter-box">
                            <label for="" class="form-label">Date Range</label>
                            <div class="dates-boxes     filter-row sm-row2  ">
                                <div class="date-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="date" value="{{ request()->min_date }}" name="min_date"
                                        class="form-element">
                                </div>
                                <div class="date-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="date" value="{{ request()->max_date }}" name="max_date"
                                        class="form-element">
                                </div>
                            </div>
                        </div>
                        <div class="filter-box">
                            <label for="" class="form-label">Value</label>
                            <div class="numbers-range-boxes filter-row sm-row2 ">
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">From : </p>
                                    <input type="number" pattern="^\d{8}$" inputmode="numeric" class="form-element"
                                        value="{{ request()->min_value }}" name="min_value" placeholder="eg: 50" />

                                </div>
                                <div class="number-box min-grid">
                                    <p class="limiters form-limiters">To : </p>
                                    <input type="number" pattern="^\d{8}$" inputmode="numeric"
                                        class="form-element"name="max_value"
                                        value="{{ request()->max_value }}"placeholder="eg: 100" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="buttons d-flex j-end gap-1 wrap mt-1">
                        <button type="reset" class="resetBtn">Reset</button>
                        <button type="submit" id="submitBtn" class="submitBtn">Filter</button>

                    </div>
                </form>
            </div>
        </div>
        <!-- End Filters -->

        @if ($vouchers->count() > 0)
            <div class="results  ">
                <div class="results-holder main-holder vouchers">
                    @foreach ($vouchers as $voucher)
                        <!-- Start Voucher  -->
                        <div class="voucher card">
                            <div class="header d-flex j-sp-between a-center">
                                <img src="{{ asset('storage/' . $voucher->category->icon) }}" alt="">
                                <p class="value">{{ $voucher->value }} DT</p>
                            </div>
                            <p class="voucher-number">{{ substr($voucher->code, 0, 4) }}**********</p>
                            <div class="details d-flex  j-sp-between a-center ">
                                <div class="detail">
                                    <p> {{ \Carbon\Carbon::parse($voucher->created_at)->format('M jS Y') }} </p>

                                </div>
                                <div class="detail">
                                    <p>{{ $voucher->status }}</p>
                                </div>
                            </div>

                            <button aria-label="Show Voucher's Details" class="show-voucher-btn"></button>
                            <div class="modal-holder ">
                                <div class="modal voucher-details">
                                    <header class="modal-header d-flex j-sp-between a-center">
                                        <h2>#{{ $voucher->id }}</h2>
                                        <button class="close-modal-holder-btn"><i class="fa-light fa-close"></i></button>
                                    </header>

                                    <div class="header d-flex j-sp-between a-center">
                                        <img src="{{ asset('storage/' . $voucher->category->icon) }}" alt="">
                                        <p class="value"> {{ $voucher->value }} DT</p>
                                    </div>
                                    <p class="voucher-number">
                                        {{ $voucher->code }}

                                    </p>
                                    <div class="details d-flex  j-sp-between a-center ">
                                        <div class="detail">
                                            <p>{{ \Carbon\Carbon::parse($voucher->created_at)->format('M jS Y') }} </p>
                                        </div>
                                        <div class="detail">
                                            <p>{{ $voucher->status }}</p>
                                        </div>
                                    </div>
                                    @if ($voucher->user)
                                        <div class="used-by-holder">
                                            <h3>Used By : </h3>
                                            <div class="info-holder d-flex j-start a-center">
                                                <img src="{{ asset('storage/' . $voucher->user->user->photo) }}"
                                                    alt="">

                                                <p>{{ $voucher->user->user->full_name }}
                                                    ({{ class_basename($voucher->user_type) }})
                                                </p>

                                            </div>

                                            <h3>Used At : </h3>
                                            <p>{{ $voucher->updated_at }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- End Voucher  -->
                    @endforeach
                </div>
                {!! $vouchers->appends(request()->input())->links() !!}
            </div>
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>There Is no Results!</p>
                </div>
            </div>
        @endif
    </section>
@endsection


@push('scripts')
    <script>
        const showVouchersControllers = Array.from(document.querySelectorAll('.show-voucher-btn'))

        showVouchersControllers.forEach((btn) => {
            btn.addEventListener('click', () => {
                let modalHolder = btn.nextElementSibling
                modalHolder.classList.add('show')
                document.body.classList.add('no-scroll')
            })
        })
    </script>

    {{-- <script src=" {{ asset('dist/js/modals.js') }} "></script> --}}
    @include('components.inc_modals-js')
@endpush
