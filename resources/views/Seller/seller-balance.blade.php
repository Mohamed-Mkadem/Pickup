@extends('layouts.Seller')

@push('title')
    <title>Pickup | Balance</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Balance</h1>

            <button class="header-btn add-btn pop-up-controller" id="add-btn"> <i class="fa-light fa-plus"></i> Add
                Balance</button>
            <div class="pop-up-holder ">
                <div class="pop-up form-pop-up">
                    <div class="pop-up-header d-flex j-sp-between a-center">
                        <h2>Add Balance</h2>
                        <button class="close-pop-up-btn"><i class="fa-light fa-close"></i></button>
                    </div>
                    <div class="pop-up-body">
                        <!-- Start Form -->
                        <form action="{{ route('seller.topup') }}" method="post" id="balance-form">
                            @csrf
                            <div class="form-control">
                                <label for="" class="d-block required form-label">
                                    Voucher Code :
                                </label>
                                <input type="number" name="code" id="voucher-input" placeholder="eg: 500-021-214-0254"
                                    class="form-element">
                                <p class="error-message">This Field Is Required</p>
                            </div>

                            <div class="form-control d-flex j-end">
                                <button type="submit">Confirm</button>
                            </div>
                        </form>
                        <!-- End Form -->

                    </div>
                </div>
            </div>

        </div>
        <!-- End Starter Header -->

        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Quick Stats Holder -->
        <div class="quick-stats-holder " id="quick-stats-holder">
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Available (DT)</p>
                        <p class="box-value">{{ $seller->balance }} </p>
                    </div>

                    <div class="icon-holder">
                        <i class="fa-solid fa-sack-dollar payment"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Store Balance (DT)</p>
                        <p class="box-value">{{ $seller->store->balance }} </p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-regular fa-shop validation"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->
            <!-- Start Stat -->
            <div class="stat-item">
                <!-- Start Top Info -->
                <div class="top-info mb-0 d-flex a-start j-sp-between">
                    <div class="title-value-box">
                        <p class="box-title">Suspended (DT)</p>

                        <p class="box-value">{{ $seller->suspendedBalance() }} </p>
                    </div>

                    <div class="icon-holder">

                        <i class="fa-solid fa-xmark rejected"></i>
                    </div>

                </div>
                <!-- End Top Info -->

            </div>
            <!-- End Stat -->


        </div>
        <!-- End Quick Stats Holder -->
    </section>
@endsection

@push('scripts')
    <script>
        // const balanceForm = document.getElementById('balance-form')
        // const voucherInput = document.getElementById('voucher-input')
        // balanceForm.addEventListener('submit', (e) => {
        //     e.preventDefault()
        //     let errors = 0
        //     errors += validateField(voucherInput, voucherInput.nextElementSibling)

        //     if (!errors) {
        //         balanceForm.submit()
        //     }

        // })
        // function validateField(field, errorMessage) {
        //     let errors = 0
        //     if (!field.value) {
        //         errorMessage.textContent = 'This Field Is Required'
        //         errorMessage.classList.add('show')
        //         errors = 1
        //     } else {
        //         errorMessage.textContent = ''
        //         errorMessage.classList.remove('show')
        //         errors = 0
        //     }
        //     return errors
        // }
    </script>
@endpush
