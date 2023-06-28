@extends('layouts.Seller')

@push('title')
    <title>Pickup | New Verification Request</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>New Verification Request</h1>
        </div>
        <!-- End Starter Header -->

        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        {{-- @if (Auth::user()->seller->hasPendingVerificationRequest())
            <div class="alert-info alert full-width">
                <h3>Info</h3>
                <p>
                    We Recieved Your Verification Request , Please wait until we review It <br>
                    Thank You For Your Patience
                </p>
            </div>
        @else
            @if (Auth::user()->seller->isVerified())
                <div class="alert-success alert full-width">
                    <h3>Info</h3>
                    <p>
                        Your Account Is Already Verified! You are not asked to send Anything <br>
                        Enjoy
                    </p>
                </div>
            @else
                @if (!Auth::user()->seller->hasSentVerificationRequest())
                    <div class="alert-info alert full-width">
                        <h3>Info</h3>
                        <p>
                            Please Double Check Your Information before submitting the Verification Request, You Cannot
                            change Your account details after submitting the Request
                            <a href="{{ route('seller.profile') }}">Update Account Details</a>
                        </p>
                    </div>
                @endif --}}
        <form action="{{ route('seller.verification-requests.store') }}" method="post" id="verification-form"
            enctype="multipart/form-data">
            @csrf
            @if (!Auth::user()->seller->hasSentVerificationRequest())
                <div class="main-holder mt-2 form-block">
                    <div class="d-flex j-sp-between mb-1 a-center wrap gap-0-5">
                        <h2 class="form-holder-title ">General Info</h2>
                        <a href="{{ route('profile.edit') }}" class="editBtn"> <i class="fa-light fa-pen"></i>
                            Edit</a>
                    </div>
                    <div class="form-row">
                        <div class="form-control">
                            <label for="" class="form-label">First Name</label>
                            <input type="text" name="" readonly id="f-name-input"
                                value="{{ Auth::user()->first_name }}" class="form-element   ">
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label">Last Name</label>
                            <input type="text" name="" readonly id="l-name-input"
                                value="{{ Auth::user()->last_name }}" class="form-element   ">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-control">
                            <label for="" class="form-label">N.I.D</label>
                            <input type="text" name="" readonly id="nid"
                                value="{{ Auth::user()->seller->nid }}" class="form-element ">
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label">Gender</label>
                            <input type="text" name="" readonly id="gender" value="{{ Auth::user()->gender }}"
                                class="form-element ">
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label">D.O.B</label>
                            <input type="text" name="" readonly id="dob" value="{{ Auth::user()->d_o_b }}"
                                class="form-element ">
                        </div>
                    </div>
                    <div class="results mt-1">
                        <div class="results-holder bank-info">

                            <!-- Start Info -->
                            <div class="info main-holder light p-1 radius-10 shadow-1 m-0">
                                <div class="info-title d-flex j-start a-center ">
                                    <i class="fa-light fa-bank"></i>
                                    <h3>Bank</h3>
                                </div>
                                <div class="info-value">
                                    <p>{{ Auth::user()->seller->bank }}</p>
                                </div>
                            </div>
                            <!-- End Info -->

                            <!-- Start Info -->
                            <div class="info main-holder light p-1 radius-10 shadow-1 m-0">
                                <div class="info-title d-flex j-start a-center ">
                                    <i class="fa-light fa-user"></i>
                                    <h3>Account Holer</h3>
                                </div>
                                <div class="info-value">
                                    <p>{{ Auth::user()->seller->account_name }}</p>
                                </div>
                            </div>
                            <!-- End Info -->

                            <!-- Start Info -->
                            <div class="info main-holder light p-1 radius-10 shadow-1 m-0">
                                <div class="info-title d-flex j-start a-center ">
                                    <i class="fa-light fa-bank"></i>
                                    <h3>R.I.B</h3>
                                </div>
                                <div class="info-value">
                                    <p>{{ Auth::user()->seller->rib }}</p>
                                </div>
                            </div>
                            <!-- End Info -->

                        </div>
                    </div>
                </div>
            @endif
            <div class="main-holder mt-2 form-block">
                <h2 class="form-holder-title mb-1">Documents</h2>
                <div class="form-row mb-1">
                    <div class="form-col">
                        <h3 class="col-title">Photo</h3>
                        <p class="col-body"> Upload a recent and clear photograph of yourself. Ensure that
                            your face is well-lit, visible, and recognizable. Avoid wearing accessories or
                            items that may obstruct your face.</p>
                    </div>
                    <div class="form-col form-control mb-0">
                        <label for="" class="d-block required form-label">Photo</label>
                        <div class="drop-zone form-element">
                            <label for="icon-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="photo" class="file-input"
                                accept="image/jpeg image/png, image/jpg, image/svg">
                        </div>
                        <p class="error-message">This Field is Required</p>
                        <div class="upload-area d-flex j-start a-center ">
                            <i class="fa-solid fa-file-image"></i>
                            <div class="file-info">
                                <p class="file-name">FileName.png </p>
                                <p class="file-size">485 KB</p>
                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="form-col">
                        <h3 class="col-title">NID Front</h3>
                        <p class="col-body"> Upload a clear and legible image of the front face of your
                            National ID card. Ensure that all details, including your name and photo, are
                            clearly visible.</p>
                    </div>
                    <div class="form-col form-control mb-0">
                        <label for="" class="d-block required form-label">NID Front</label>
                        <div class="drop-zone form-element">
                            <label for="icon-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="nid_front" class="file-input"
                                accept="image/jpeg image/png, image/jpg, image/svg">
                        </div>
                        <p class="error-message">This Field is Required</p>
                        <div class="upload-area d-flex j-start a-center ">
                            <i class="fa-solid fa-file-image"></i>
                            <div class="file-info">
                                <p class="file-name">FileName.png </p>
                                <p class="file-size">485 KB</p>
                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="form-col">
                        <h3 class="col-title">NID Back</h3>
                        <p class="col-body">Upload a clear and legible image of the back face of your
                            National ID card. Make sure that any important information or signatures on the
                            back are clearly captured.</p>
                    </div>
                    <div class="form-col form-control mb-0">
                        <label for="" class="d-block required form-label">NID Back</label>
                        <div class="drop-zone form-element">
                            <label for="icon-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="nid_back" class="file-input"
                                accept="image/jpeg image/png, image/jpg, image/svg">
                        </div>
                        <p class="error-message">This Field is Required</p>
                        <div class="upload-area d-flex j-start a-center ">
                            <i class="fa-solid fa-file-image"></i>
                            <div class="file-info">
                                <p class="file-name">FileName.png </p>
                                <p class="file-size">485 KB</p>
                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="form-row mb-1">
                    <div class="form-col">
                        <h3 class="col-title">Commercial Register</h3>
                        <p class="col-body">Upload a scanned or photographed copy of your valid commercial
                            register document. Ensure that all relevant information, such as your business
                            name, registration number, and address, is clearly visible.</p>
                    </div>
                    <div class="form-col form-control mb-0">
                        <label for="" class="d-block required form-label">Commercial Register</label>
                        <div class="drop-zone form-element">
                            <label for="icon-image" class="drop-zone-label form-label">
                                <i class="fa-light fa-cloud-arrow-up d-block"></i>
                                <p>Drop File Here Or Click To Upload File</p>
                                <p>Allowed Formats are jpg, jpeg</p>
                            </label>
                            <input type="file" name="commercial_register" class="file-input"
                                accept="image/jpeg image/png, image/jpg, image/svg">
                        </div>
                        <p class="error-message">This Field is Required</p>
                        <div class="upload-area d-flex j-start a-center ">
                            <i class="fa-solid fa-file-image"></i>
                            <div class="file-info">
                                <p class="file-name">FileName.png </p>
                                <p class="file-size">485 KB</p>
                            </div>
                            <i class="fa-light fa-check"></i>
                        </div>
                    </div>
                </div>
                <div class="buttons d-flex j-end gap-1 wrap mt-2">
                    <button type="reset" class="resetBtn" id="reset-btn">Reset</button>
                    <button type="submit" id="submitBtn" class="submitBtn">Submit</button>
                </div>
            </div>
        </form>
        {{-- @endif
        @endif --}}
    </section>
@endsection

@push('scripts')
    <script>
        const verificationForm = document.getElementById('verification-form')
        if (verificationForm) {


            const fileInputs = document.querySelectorAll('.file-input')
            verificationForm.addEventListener('submit', (e) => {
                e.preventDefault()
                let errors = 0
                for (let i = 0; i < fileInputs.length; i++) {

                    errors += validateField(fileInputs[i], fileInputs[i].parentElement.nextElementSibling)
                }
                if (!errors) {
                    verificationForm.submit()
                }

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
            fileInputs.forEach((fileInput) => {
                fileInput.addEventListener('change', () => {
                    if (validateFileType(fileInput)) {
                        showFileInfo(fileInput)

                    } else {
                        showFileTypeError(fileInput)
                    }

                })
            })

            function showFileInfo(input) {
                let errorMessage = input.parentElement.nextElementSibling
                let uploadArea = errorMessage.nextElementSibling
                let fileNameHolder = uploadArea.children[1].children[0]
                let fileSizeHolder = uploadArea.children[1].children[1]
                errorMessage.classList.remove('show')
                errorMessage.textContent = '';
                let fileSize = Math.floor(input.files[0].size / 1000)
                let fileName = input.files[0].name
                if (fileName.length > 12) {
                    let splitName = fileName.split('.')
                    fileName = splitName[0].substring(0, 12) + '... .' + splitName[1];
                    console.log(fileName);
                }
                uploadArea.classList.add('show')
                fileNameHolder.textContent = fileName
                fileSizeHolder.textContent = fileSize > 1000 ? `${Math.floor(fileSize / 1000)} MB` : `${fileSize} KB`
            }

            function validateFileType(actualFileInput) {
                allowedExtensions = /(\.jpg|\.jpeg)$/i
                return allowedExtensions.exec(actualFileInput.files[0].name);

            }

            function showFileTypeError(input) {
                let errorMessage = input.parentElement.nextElementSibling
                let uploadArea = errorMessage.nextElementSibling
                uploadArea.classList.remove('show')
                input.value = ''
                errorMessage.textContent = 'We Only Accept Jpeg, Jpg Formats'
                errorMessage.classList.add('show')
            }
            const resetBtn = document.getElementById('reset-btn')
            const uploadAreas = document.querySelectorAll('.upload-area')
            resetBtn.addEventListener('click', () => {
                let errorMessages = document.querySelectorAll('.error-message')
                errorMessages.forEach((msg) => {
                    msg.textContent = ''
                    msg.classList.remove('show')
                })
                uploadAreas.forEach((area) => {
                    let fileName = area.querySelector('.file-name')
                    let fileSize = area.querySelector('.file-size')
                    fileName.textContent = ''
                    fileSize.textContent = ''
                    area.classList.remove('show')
                    let input = area.previousElementSibling.previousElementSibling.querySelector('input')
                    input.value = ''
                })
            })
        }
    </script>
@endpush
