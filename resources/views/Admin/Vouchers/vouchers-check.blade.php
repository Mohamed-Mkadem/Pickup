@extends('layouts.Admin')

@push('title')
    <title>Pickup | Check Voucher </title>
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
        <p class="loader-message">thank you for your patience</p>
    </div>
@endsection
@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Check Voucher</h1>
        </div>
        {{-- Errors Container --}}
        <div id="errors-container"></div>
        <!-- End Starter Header -->
        <div class="main-holder">
            <form action="{{ route('admin.vouchers.show') }}" id="check-form" method="post">
                @csrf
                <div class="form-row check-row">
                    <div class="form-control">
                        <label for="" class="form-label required">Voucher's ID</label>
                        <input type="number" name="id" id="id-input" placeholder="The voucher's ID to check"
                            class="form-element">
                        <p class="error-message ">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <button class="submit-btn">Check </button>

                    </div>
                </div>

            </form>
        </div>


        @if (@$voucher)
            <div class=" results ">
                <h2>Result</h2>
                <div class="wrapper d-flex j-center a-center">
                    <div class="voucher-result card">
                        <header class="result-header">
                            <h2>#25400</h2>

                        </header>
                        <div class="header d-flex j-sp-between a-center">
                            <img src="../../dist/Assets/store.svg" alt="">
                            <p class="value">50 DT</p>
                        </div>
                        <p class="voucher-number">

                            4254 2451 0214 0254
                        </p>
                        <div class="details d-flex  j-sp-between a-center ">
                            <div class="detail">
                                <p> 25 - 10 - 2022 </p>
                            </div>
                            <div class="detail">
                                <p>Unused</p>
                            </div>
                        </div>

                        <div class="used-by-holder">
                            <h3>Used By : </h3>
                            <div class="info-holder d-flex j-start a-center">
                                <img src="../../dist/Assets/avatar-aden.jpg" alt="">
                                <p>Mohamed Mkadem</p>
                            </div>

                            <h3>Used At : </h3>
                            <p>20 - 10 - 2022</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Vouchers Found!</p>
                </div>
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script>
        const checkForm = document.getElementById('check-form')
        const idInput = document.getElementById('id-input')
        checkForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0

            // errors += validateField(idInput, idInput.nextElementSibling)

            if (!errors) {
                sendPostRequest(checkForm, checkForm.action)
            }
        })


        function dataLoaded(req) {
            loader.classList.remove('show')
            if (req.status === 200) {
                let data = JSON.parse(req.response)
                console.log(data['success']);
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
                    console.log(errorKey + ': ' + value);
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
                // dataLoaded(request)
                console.log(request.response);
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
