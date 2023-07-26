@extends('layouts.Seller')

@push('title')
    <title>Pickup | New Subscription</title>
@endpush
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>New Subscription</h1>
        </div>
        <!-- End Starter Header -->
        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')


        @if (!$seller->hasStore())
            <div class=" alert alert-light  mb-1">
                <h3 class="t-left mt-0">
                    Notice :
                </h3>
                <p>
                    You Didn't Create Any Store Yet! <a href="{{ route('seller.stores.create') }}">Create A Store Now</a>
                </p>
            </div>
        @else
            @if (!$fee)
                <div class=" alert alert-light  mb-1">
                    <h3 class="t-left mt-0">
                        Notice :
                    </h3>
                    <p>
                        There Is No Plans Available Now, Please Try Later</a>
                    </p>
                </div>
            @else
                <div class=" alert alert-light mb-1">
                    <h3 class="t-left mt-0">
                        Notice :
                    </h3>
                    <p>
                        Your Store Expiry Date Is
                        {{ $seller->store->expiry_date == null ? 'Undefined Yet' : \Carbon\Carbon::parse($seller->store->expiry_date)->format('M jS Y') }}
                    </p>
                </div>
                <div class="results">
                    <h2 class="t-left mb-1">Available Plans</h2>
                    <form action="{{ route('seller.stores.subscriptions.store') }}" method="post" id="plans-form">
                        @csrf
                        <div class="results-holder subscription-plans">
                            @for ($i = 1; $i <= 12; $i++)
                                <!-- Start Subscription Plan -->
                                <div class="plan holder radius-10 p-1">
                                    <h3 class="plan-price">{{ $fee->value * $i }} <small>DT</small></h3>
                                    <p class="plan-duration"> {{ $i == 1 ? '1 Month' : "$i Months" }}</p>
                                    <input type="radio" name="plan" value="  {{ $i }}"
                                        {{ $i == 1 ? 'checked' : '' }}>
                                </div>
                                <!-- End Subscription Plan -->
                            @endfor

                        </div>
                        <div class="buttons d-flex j-end a-center mt-1">
                            <button class="submit-btn " id="modal-btn">Purchase</button>
                            <div class="modal-holder ">
                                <div class="modal t-center">
                                    <i class=" fa-light fa-info "></i>
                                    <p class="m-block-1">Are You Sure You Want To Confirm Your Purchase ?</p>
                                    <div class="buttons d-flex j-center a-center gap-1 wrap ">
                                        <button class="cancelBtn visited-button">Cancel</button>
                                        <button class="confirmBtn activate-button">Yes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endif
    </section>
@endsection

@push('scripts')
@endpush
