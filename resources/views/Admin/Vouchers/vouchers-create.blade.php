@extends('layouts.Admin')

@push('title')
    <title>Pickup | Create Vouchers </title>
@endpush
@push('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush
@section('loader')
    <div id="loader" class="">
        <div class="loader-spinner ">
            <div class="inner-spinner"></div>
        </div>
        <h2 class="loader-title">Preparing your request...</h2>
        <p class="loader-message">Thank you for your patience</p>
    </div>
@endsection
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>New Vouchers</h1>
        </div>

        {{-- Errors Container --}}
        <div id="errors-container"></div>
        <!-- End Starter Header -->
        @include('components.success-alert')
        @include('components.session-errors-alert')
        <div class="main-holder">
            <form action="{{ route('admin.vouchers.store') }}" id="creation-form" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label required">Category</label>
                        <div class="select-box">
                            <select name="category_id" class="form-element" id="category-input">
                                @foreach ($vouchersCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </select>
                            <p class="error-message" id="category-error-message">This Field Is Required</p>
                        </div>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label required">Quantity</label>
                        <input type="number" name="quantity" placeholder="How Many Vouchers You want to generate"
                            id="quantity-input" class="form-element">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label required">Cost Per One (DT)</label>
                        <input type="number" name="cost" placeholder="The cost of each voucher" id="cost-input"
                            class="form-element">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label required">Price Per One (DT)</label>
                        <input type="number" name="price" id="price-input" class="form-element"
                            placeholder="The sale price of each voucher">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="d-flex j-end a-center">
                    <button class="submit-btn">Add </button>
                </div>
            </form>
        </div>


        <div id="message-holder" class="message-holder  main-holder t-center">
            <div class="wrapper">
                <i class=" fa-light fa-check"></i>
                <p>1500 Vouchers Added Successfully</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const starterHeader = document.getElementById('starter-header')
        const successAlert = document.querySelector('.alert-success')
        const messageHolder = document.getElementById('message-holder')
        const errorsContainer = document.getElementById('errors-container')
        const loader = document.getElementById('loader')
        const creationForm = document.getElementById('creation-form')
        const categoryInput = document.getElementById('category-input')
        const categoryInputErrorMessage = document.getElementById('category-error-message')
        const quantityInput = document.getElementById('quantity-input')
        const priceInput = document.getElementById('price-input')
        const costInput = document.getElementById('cost-input')
        creationForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0

            errors += validateField(quantityInput, quantityInput.nextElementSibling)
            errors += validateField(priceInput, priceInput.nextElementSibling)
            errors += validateField(costInput, costInput.nextElementSibling)
            errors += validateField(categoryInput, categoryInputErrorMessage)
            if (!errors) {
                // creationForm.submit()
                sendPostRequest(creationForm, creationForm.action)
            }
        })



        function dataLoaded(req) {
            loader.classList.remove('show')
            if (req.status === 200) {
                let data = JSON.parse(req.response)

                errorsContainer.innerHTML = ''

                message = messageHolder.querySelector('p')
                message.textContent = data['success']
                // message.textContent = req.response
                messageHolder.classList.add('show')
                creationForm.reset()
            } else {
                errorsContainer.innerHTML = ''
                messageHolder.classList.remove('show')
                let errorAlert = document.createElement('ul')
                errorAlert.className = 'alert alert-error mb-1'
                data = JSON.parse(req.response)
                for (var errorKey in data.errors) {
                    var value = data.errors[errorKey];

                    let li = document.createElement('li')
                    li.textContent = data.errors[errorKey];
                    errorAlert.append(li)
                }

                errorsContainer.append(errorAlert)


            }

        }

        function sendPostRequest(form, route) {
            const request = new XMLHttpRequest();
            const FD = new FormData(form);

            request.open("POST", route);
            request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            request.setRequestHeader("X-CSRF-TOKEN", document.head.querySelector("[name=csrf-token]").content)
            request.send(FD)
            loader.classList.add('show')
            request.addEventListener("load", (event) => {
                dataLoaded(request)

            });


            request.addEventListener("error", (event) => {
                alert("Oops! Something went wrong.");
            });
        }

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
    </script>
@endpush
