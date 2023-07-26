@extends('layouts.Seller')

@push('title')
    <title>Pickup | Edit Profile</title>
@endpush


@section('content')
    <section class="content" id="content">

        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Edit Profile</h1>
        </div>
        <!-- End Starter Header -->
        @if ($errors->any())
            <ul class="alert alert-error mb-1">
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        @endif

        @if (session()->has('success'))
            {
            <div class="alert alert-success">{{ session()->get('success') }}</div>
            }
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success mb-1">{{ session()->get('status') }}</div>
        @endif


        {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
                <div class="mb-2 holder radius-10 p-1" style="width:min(500px, 90%);">
                    <p class="form-label mb-2">
                        You Need To verfify Your Email, In Order To Be Able to continue using the platform properly.
                        Please Click On the link you just received on your inbox
                    </p>

                    <button class="submitBtn">Click here to re-send the verification email</button>


                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1" style="color:var(--clr-green-400); font-weight:500;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            </form>
        @endif --}}
        <form action="{{ route('seller.profile.update') }}" method="post" id="general-info-form"
            enctype="multipart/form-data">
            @csrf
            @method('PATCH')


            <div class=" holder radius-10 p-1 mb-2">
                <div class="form-control">
                    <label for="" class="form-label ">Avatar </label>
                    <div class="drop-zone form-element">
                        <label for="avatar-image" class="drop-zone-label form-label">
                            <i class="fa-light fa-cloud-arrow-up d-block"></i>
                            <p>Drop File Here Or Click To Upload File</p>
                            <p>Dimensions : 256px x 256px, Allowed Formats are png, jpeg, Max Size : 1 MB</p>
                        </label>
                        <input type="file" name="photo" id="avatar-image" accept="image/jpeg image/png, image/jpg">
                    </div>
                    <p class="error-message" id="avatar-error-message">This Field Is Required</p>
                    <div class="upload-area d-flex j-start a-center ">
                        <i class="fa-solid fa-file-image"></i>
                        <div class="file-info">
                            <p class="file-name">
                                FileName.png </p>
                            <p class="file-size">485 KB</p>

                        </div>
                        <i class="fa-light fa-check"></i>
                    </div>
                </div>
            </div>
            @if (!$user->seller->hasSentVerificationRequest())
                <div class="holder radius-10 p-1 mb-2">
                    <div class="form-row">
                        <div class="form-control">
                            <label for="" class="form-label">First Name</label>
                            <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-element"
                                id="f-name-input" placeholder="eg: Mohamed" value="Mohamed">
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-element"
                                id="l-name-input" placeholder="eg: Mkadem" value="Mkadem">
                            <p class="error-message">This Field Is Required</p>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-control">
                            <label for="" class="form-label">NID</label>
                            <input type="number" name="nid" value="{{ $user->seller->nid }}" class="form-element"
                                id="nid-input" placeholder="eg: 25412145" value="25410254" maxlength="8"
                                inputmode="numeric">

                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label class="form-label">Gender :</label>
                            <div class="select-box">
                                <select name="gender" id="gender-select" class="form-element">
                                    <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label class=" form-label">Date Of Birth :</label>
                            <input type="date" name="d_o_b" value="{{ $user->d_o_b }}" id="dob-input"
                                class="form-element blue">
                            <p class="error-message">This Field Is Required</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="holder radius-10 p-1 mb-2">

                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-element"
                            id="email-input" placeholder="eg: Mohamed@gmail.com" value="mkadem@gmail.com">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label">Phone</label>
                        <input type="number" name="phone" value="{{ $user->phone }}" class="form-element"
                            id="phone-input" placeholder="eg: 25412145" value="25410254" maxlength="8"
                            inputmode="numeric">

                        <p class="error-message">This Field Is Required</p>
                    </div>

                </div>
            </div>
            <div class="holder radius-10 p-1 mb-2">
                <div class="form-row">
                    <div class="form-control">
                        <label class="form-label">State :</label>
                        <div class="select-box">
                            <select name="state_id" class="form-element" id="state-select" onchange="getCities()">



                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}"
                                        {{ old('state_id', $user->state_id) == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label class="form-label">City :</label>
                        <div class="select-box">
                            <select name="city_id" id="city-select" class="form-element">

                                @foreach ($user->city->state->cities as $city)
                                    <option value="{{ $city->id }}" @if ($city->id == $user->city_id) selected @endif>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label">Address</label>
                        <input type="text" name="address" value="{{ $user->address }}" class="form-element"
                            id="address-input" placeholder="eg: 25 Awesome Street Name">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>

                <div class="buttons d-flex j-end gap-1 wrap mt-1">
                    <button type="reset" class="resetBtn generalFormResetBtn">Reset</button>
                    <button type="submit" class="submitBtn">Save</button>

                </div>
            </div>
            <!-- </div> -->


        </form>
        <div class="results">
            <div class="results-holder seller-edit-forms">
                <form action="{{ route('password.update') }}" method="post" id="password-form">
                    @csrf
                    @method('PUT')
                    <div class="holder radius-10 p-1">
                        <h2 class="mb-1 form-holder-title">Password</h2>
                        <div class="form-control">
                            <label for="" class="form-label required">Current Password</label>
                            <input type="password" required class="form-element" placeholder="Type The Current Password"
                                name="current_password" id="current-password">
                            @if ($errors->updatePassword)
                                @foreach ($errors->updatePassword->get('current_password') as $message)
                                    <p class="error-message show"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label required">New Password</label>
                            <input type="password" required class="form-element" placeholder="Type A Strong Password"
                                name="password" id="new-password">
                            @if ($errors->updatePassword)
                                @foreach ($errors->updatePassword->get('password') as $message)
                                    <p class="error-message show"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label for="" class="form-label required">Confirm Password</label>
                            <input type="password" required class="form-element" placeholder="Confirtm Password"
                                name="password_confirmation" id="confirm-password">
                            @if ($errors->updatePassword)
                                @foreach ($errors->updatePassword->get('password_confirmation') as $message)
                                    <p class="error-message show"> {{ $message }} </p>
                                @endforeach
                            @endif
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="buttons d-flex j-sp-between gap-1 wrap mt-1">
                            <button type="reset" class="resetBtn">Reset</button>
                            <button type="submit" class="submitBtn">Save</button>

                        </div>
                    </div>
                </form>
                <form action="{{ route('seller.bank.update') }}" id="bank-form" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="holder radius-10 p-1">
                        <h2 class="mb-1 form-holder-title">Bank Info</h2>
                        <div class="form-control">
                            <label class="form-label">Bank :</label>
                            <div class="select-box">
                                <select name="bank" required class="form-element" id="bank-select">
                                    <option value="BEITTNTT" {{ $user->seller->bank == 'BEITTNTT' ? 'selected' : '' }}>Al
                                        Baraka Bank</option>
                                    <option value="CFCTTNTT" {{ $user->seller->bank == 'CFCTTNTT' ? 'selected' : '' }}>
                                        Amen Bank</option>
                                    <option value="BSTUTNTT" {{ $user->seller->bank == 'BSTUTNTT' ? 'selected' : '' }}>
                                        Attijari Bank</option>
                                    <option value="BNTETNTT" {{ $user->seller->bank == 'BNTETNTT' ? 'selected' : '' }}>
                                        Banque Nationale Agricole</option>
                                    <option value="TUSOTNT1" {{ $user->seller->bank == 'TUSOTNT1' ? 'selected' : '' }}>
                                        Banque Tunisienne de Solidarité</option>
                                    <option value="BTKOTNTT" {{ $user->seller->bank == 'BTKOTNTT' ? 'selected' : '' }}>
                                        Banque Tuniso Koweitienne</option>
                                    <option value="BZITTNTT" {{ $user->seller->bank == 'BZITTNTT' ? 'selected' : '' }}>
                                        Banque Zitouna</option>
                                    <option value="BTBKTNTT" {{ $user->seller->bank == 'BTBKTNTT' ? 'selected' : '' }}>
                                        Banque de Tunisie</option>
                                    <option value="BTEXTNTT" {{ $user->seller->bank == 'BTEXTNTT' ? 'selected' : '' }}>
                                        Banque de Tunisie et des Emirats</option>
                                    <option value="BHBKTNTT" {{ $user->seller->bank == 'BHBKTNTT' ? 'selected' : '' }}>
                                        Banque de l'Habitat</option>
                                    <option value="CITITNTX" {{ $user->seller->bank == 'CITITNTX' ? 'selected' : '' }}>
                                        Citi Bank</option>
                                    <option value="LPTNTNTT" {{ $user->seller->bank == 'LPTNTNTT' ? 'selected' : '' }}>La
                                        Poste Tunisienne</option>
                                    <option value="BTQITNTT" {{ $user->seller->bank == 'BTQITNTT' ? 'selected' : '' }}>
                                        Qatar National Bank</option>
                                    <option value="STBKTNTT" {{ $user->seller->bank == 'STBKTNTT' ? 'selected' : '' }}>
                                        Société Tunisienne de Banque</option>
                                    <option value="TSIDTNTT" {{ $user->seller->bank == 'TSIDTNTT' ? 'selected' : '' }}>
                                        Tunisian Saudi Bank</option>
                                    <option value="UIBKTNTT" {{ $user->seller->bank == 'UIBKTNTT' ? 'selected' : '' }}>
                                        Union Internationale de Banque</option>
                                </select>
                            </div>
                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label class="form-label">Account Name :</label>
                            <input type="text" required class="form-element" name="account_name"
                                placeholder="eg: Mohamed Mkadem" id="account-name"
                                value="{{ $user->seller->account_name }}" />

                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="form-control">
                            <label class="form-label">Account Number :</label>
                            <input type="number" required class="form-element" name="rib" placeholder="RIB"
                                id="rib" pattern="^\d{20,20}$" maxlength="20" inputmode="numeric"
                                value="{{ $user->seller->rib }}" />

                            <p class="error-message">This Field Is Required</p>
                        </div>
                        <div class="buttons d-flex j-sp-between gap-1 wrap mt-1">
                            <button type="reset" class="resetBtn">Reset</button>
                            <button type="submit" class="submitBtn">Save</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection


@push('scripts')
    {{-- <script>
        const errorMessages = document.querySelectorAll('.error-message')

        function hideErrorMessages() {

            errorMessages.forEach((msg) => {
                msg.textContent = ''
                msg.classList.remove('show')
            })
        }
        const generalInfoForm = document.getElementById('general-info-form')
        const avatarInput = document.getElementById('avatar-image')
        const avatarInputErrorMessage = document.getElementById('avatar-error-message')
        const fNameInput = document.getElementById('f-name-input')
        const lNameInput = document.getElementById('l-name-input')
        const emailInput = document.getElementById('email-input')
        const phoneInput = document.getElementById('phone-input')
        const stateSelect = document.getElementById('state-select')
        const citySelect = document.getElementById('city-select')
        const genderSelect = document.getElementById('gender-select')
        const dobInput = document.getElementById('dob-input')
        const addressInput = document.getElementById('address-input')
        const nIDField = document.getElementById('nid-input')

        function validateNID() {
            let errors = 0
            let errorMessage = nIDField.nextElementSibling
            if (!nIDField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (!nIDField.value.match(/^[0-9]{8}$/g)) {
                errorMessage.textContent = 'Enter A Valid ID Number (8 Digits)'
                errorMessage.classList.add('show')
                errors = 1

            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0

            }
            return errors
        }
        generalInfoForm.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            if (fNameInput) {

                errors += validateField(fNameInput, fNameInput.nextElementSibling)
            }
            if (lNameInput) {

                errors += validateField(lNameInput, lNameInput.nextElementSibling)
            }
            if (genderSelect) {

                errors += validateField(genderSelect, genderSelect.parentElement.nextElementSibling)
            }
            if (nIDField) {

                errors += validateNID()
            }

            errors += validateField(emailInput, emailInput.nextElementSibling)
            errors += validatePhone(phoneInput)
            errors += validateField(addressInput, addressInput.nextElementSibling)
            errors += validateField(stateSelect, stateSelect.parentElement.nextElementSibling)
            errors += validateField(citySelect, citySelect.parentElement.nextElementSibling)
            if (!errors) {
                generalInfoForm.submit()
            }
        })

        function validatePhone(phoneField) {
            let errors = 0;
            let errorMessage = phoneField.nextElementSibling
            if (!phoneField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (!phoneField.value.match(/^[0-9]{8}$/g)) {
                errorMessage.textContent = 'Please Enter A Valid Phone Number (8 Digits)'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
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
        avatarInput.addEventListener('change', () => {
            if (validateFileType(avatarInput)) {
                showFileInfo(avatarInput)

            } else {
                showFileTypeError(avatarInput)
            }
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
            allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i
            return allowedExtensions.exec(actualFileInput.files[0].name);

        }

        function showFileTypeError(input) {
            let errorMessage = input.parentElement.nextElementSibling
            let uploadArea = errorMessage.nextElementSibling
            uploadArea.classList.remove('show')
            input.value = ''
            errorMessage.textContent = 'We Only Accept Jpeg, Jpg, Png Formats'
            errorMessage.classList.add('show')
        }

        const generalFormResetBtn = document.querySelector('.generalFormResetBtn')
        generalFormResetBtn.addEventListener('click', () => {
            hideErrorMessages()
            let area = document.querySelector('.upload-area')
            let fileName = area.querySelector('.file-name')
            let fileSize = area.querySelector('.file-size')
            fileName.textContent = ''
            fileSize.textContent = ''
            area.classList.remove('show')
        })








        const passwordFrom = document.getElementById('password-form')
        passwordFrom.addEventListener('submit', (e) => {
            e.preventDefault()
            let errors = 0
            errors += validateField(currentPassword, currentPassword.nextElementSibling)
            errors += validatePassword(newPassword, newPassword.nextElementSibling)
            errors += validatePassword(confirmPassword, confirmPassword.nextElementSibling)
            if (!errors) {
                passwordFrom.submit()
            }
        })
        const currentPassword = document.getElementById('current-password')

        function validatePassword(passwordInput, passwordInputErrorMsg) {
            let errors = 0
            if (!passwordInput.value) {
                passwordInputErrorMsg.textContent = 'This Field Is Required'
                passwordInputErrorMsg.classList.add('show')
                errors = 1
            } else {
                if (passwordInput.value.length < 8) {
                    passwordInputErrorMsg.textContent = 'Password Must Be At Least 8 Characters'
                    passwordInputErrorMsg.classList.add('show')
                    errors = 1
                } else {
                    passwordInputErrorMsg.textContent = ''
                    passwordInputErrorMsg.classList.remove('show')
                    errors = 0
                }
                if (passwordInput.id == 'confirm-password') {
                    if (confirmPassword.value != newPassword.value) {
                        passwordInputErrorMsg.textContent = 'Passwords Do Not Match'
                        passwordInputErrorMsg.classList.add('show')
                        errors = 1
                    } else {
                        passwordInputErrorMsg.textContent = ''
                        passwordInputErrorMsg.classList.remove('show')
                        errors = 0
                    }
                }

            }
            return errors

        }


        const newPassword = document.getElementById('new-password')

        const confirmPassword = document.getElementById('confirm-password')
    </script> --}}

    <script>
        const bankFrom = document.getElementById('bank-form')
        if (bankFrom) {
            const accountNameField = document.getElementById('account-name')
            console.log("file: profile-edit.blade.php:522 ~ accountNameField:", accountNameField)

            const bankField = document.getElementById('bank-select')
            console.log("file: profile-edit.blade.php:525 ~ bankField:", bankField)

            const accountNumberField = document.getElementById('rib')

            function validateRIB() {
                let errors = 0
                let errorMessage = accountNumberField.nextElementSibling
                if (!accountNumberField.value) {
                    errorMessage.textContent = 'This Field Is Required'
                    errorMessage.classList.add('show')
                    errors = 1
                } else if (!accountNumberField.value.match(/^[0-9]{20}$/g)) {
                    errorMessage.textContent = 'Enter A Valid Bank Account Number (20 Digits)'
                    errorMessage.classList.add('show')
                    errors = 1

                } else {
                    errorMessage.textContent = ''
                    errorMessage.classList.remove('show')
                    errors = 0

                }
                return errors
            }
            console.log("file: profile-edit.blade.php:527 ~ accountNumberField:", accountNumberField.nextElementSibling)
            bankFrom.addEventListener('submit', (e) => {

                let errors = 0
                e.preventDefault()
                errors += validateField(bankField, bankField.parentElement.nextElementSibling)

                errors += validateField(accountNameField, accountNameField.nextElementSibling)
                errors += validateRIB()

                if (!errors) bankFrom.submit()
            })
        }
    </script>
    <script>
        const cityField = document.getElementById('city-select')

        function getCities() {
            // Get the selected state value
            var stateId = document.getElementById('state-select').value;

            // Make an AJAX request to the server to fetch the cities based on the selected state
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    // Handle the response from the server
                    var cities = JSON.parse(xhr.responseText);

                    // Update the city select input options

                    cityField.innerHTML = ''; // Clear existing options

                    // Create new option elements for each city
                    cities.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.text = city.name;
                        cityField.appendChild(option);
                    });
                }
            };

            // Send the AJAX request
            xhr.open('GET', '/api/cities/' + stateId, true);
            xhr.send();
        }
    </script>
@endpush
