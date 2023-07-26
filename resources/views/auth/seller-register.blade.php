<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup | Seller Register</title>
    <link rel="shortcut icon" href="{{ asset('dist/Assets/favicon.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Caveat+Brush&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/dist/CSS/fe.css') }}  ">
    <link rel="stylesheet" href="{{ asset('dist/CSS/utilities.css') }}  ">
    <link rel="stylesheet" href="{{ asset('dist/CSS/fe_Dark.css') }}  ">

    <link href="https://cdn.jsdelivr.net/gh/duyplus/fontawesome-pro/css/all.min.css" rel="stylesheet" type="text/css" />
</head>

<body>


    <main class=" register">

        <div class="register-wrapper d-flex col lg-row">
            <div class="form-col col">
                <div class="container">
                    <a href="{{ route('homePage') }}" class="logo d-block visible t-center"><i
                            class="fa-light fa-bag-shopping"></i>
                        <span>Pickup</span>
                    </a>

                    @if ($errors->any())
                        <ul class="alert alert-error ">
                            @foreach ($errors->all() as $error)
                                <li> {{ $error }} </li>
                            @endforeach
                        </ul>
                    @endif
                    <form action="{{ route('registerUser') }}" id="form" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="seller">
                        <div class="steps-wrapper">
                            <!-- Start Step 1 -->
                            <div class="step " aria-current="true" data-index="0">
                                <header>
                                    <h2>Sign Up</h2>
                                    <p>Fill up Your Credentials</p>
                                </header>
                                <div class="inputs">
                                    <div class="row2x row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required" for="">First Name : </label>
                                            <input type="text" id="first-name" value="{{ old('first_name') }}"
                                                name="first_name" class="form-element" placeholder="eg: Mohamed">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                        <div class="form-control">
                                            <label class="d-block required" for="">Last Name : </label>
                                            <input type="text" name="last_name"
                                                value="{{ old('last_name') }}"id="last-name" class="form-element"
                                                placeholder="eg: Mkadem">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required" for="">Email : </label>
                                            <input type="email" name="email" value="{{ old('email') }}"
                                                id="email" class="form-element" placeholder="eg: mohamed@email.com">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required" for="">Password : </label>
                                            <input type="password" value="{{ old('password') }}" id="password"
                                                name="password" class="form-element"
                                                placeholder="At least 8 Characters">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required" for="">Confirm Password : </label>
                                            <input type="password" value="{{ old('password_confirmation') }}"
                                                name="password_confirmation" id="confirm-password" class="form-element"
                                                placeholder="Repeat The same password">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required" for="">Gender :</label>
                                            <div class="gender-wrapper d-flex row">
                                                <div class="choice">
                                                    <p>Male</p>
                                                    <input type="radio" aria-label="Gender is Male" name="gender"
                                                        value="Male" checked aria-checked="true">
                                                </div>
                                                <div class="choice">
                                                    <p>Female</p>
                                                    <input type="radio" aria-label="Gender Is female"
                                                        name="gender" value="Female" aria-checked="false">
                                                </div>
                                            </div>
                                            <p class="error-message" id="gender-error-message"></p>
                                        </div>
                                    </div>

                                </div>
                                <div class="buttons-wrapper d-flex row j-end a-center">
                                    <button class="next-btn form-btn" data-role="next button">Next</button>
                                </div>
                            </div>
                            <!-- End Step 1 -->

                            <!-- Start Step 2 -->
                            <div class="step" aria-current="false" data-index="1">
                                <header>
                                    <h2>One More Step</h2>
                                    <p>We're Almost Done</p>
                                </header>
                                <div class="inputs">
                                    <div class="row2x row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">Date Of Birth :</label>
                                            <input type="date" name="d_o_b" id="d-o-b"
                                                value="{{ old('d_o_b') }}">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                        <div class="form-control">
                                            <label class="d-block required">Phone Number :</label>
                                            <input type="number" value="{{ old('phone') }}" name="phone"
                                                id="phone" value="25412012" maxlength="8" inputmode="numeric"
                                                placeholder="eg: 20111222">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>
                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">State :</label>
                                            <div class="select-box">

                                                <select name="state_id" id="state-select" onchange="getCities()">


                                                    @foreach ($states as $state)
                                                        <option value="{{ $state->id }}"
                                                            {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                            {{ $state->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <p class="error-message">This Field Is Required</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">City :</label>
                                            <div class="select-box">
                                                <select name="city_id" id="city-select">



                                                    @if (old('state_id'))
                                                        @foreach ($states as $state)
                                                            @if ($state->id == old('state_id'))
                                                                @foreach ($state->cities as $city)
                                                                    <option value="{{ $city->id }}"
                                                                        @if (old('city_id') == $city->id) selected @endif>
                                                                        {{ $city->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @else{
                                                        @foreach ($states[0]->cities as $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                        }
                                                    @endif

                                                </select>
                                                <p class="error-message">This Field Is Required</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">Full Address :</label>
                                            <input type="text" name="address" id="address"
                                                value="{{ old('address') }}"
                                                placeholder="eg: 69 Awesome Street City - State">
                                            <p class="error-message">This Field Is Required</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="buttons-wrapper d-flex row j-sp-between a-center">
                                    <button class="back-btn form-btn" data-role="previous button">Back</button>
                                    <button class="next-btn form-btn" data-role="next button">Next</button>

                                </div>
                            </div>
                            <!-- End Step 2 -->
                            <!-- Start Step 3 -->
                            <div class="step" aria-current="false" data-index="2">
                                <header>
                                    <h2>One More Step</h2>
                                    <p>We're Almost Done</p>
                                </header>
                                <div class="inputs">
                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">N.I.D :</label>
                                            <input required type="text" placeholder="NID" id="nid"
                                                value="{{ old('nid') }}" pattern="^\d{8}$" maxlength="8"
                                                inputmode="numeric" name="nid" value="{{ old('nid') }}" />

                                            <p class="error-message">This Field Is Required</p>
                                        </div>

                                    </div>

                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">Bank :</label>
                                            <div class="select-box">
                                                <select name="bank" id="bank-select">

                                                    <option value="BEITTNTT">Al Baraka Bank</option>



                                                    <option value="CFCTTNTT">Amen Bank</option>




                                                    <option value="BSTUTNTT">Attijari Bank</option>



                                                    <option value="BIATTNTT">Banque Internationale Arabe de Tunisie
                                                    </option>

                                                    <option value="BNTETNTT">Banque Nationale Agricole</option>

                                                    <option value="TUSOTNT1">Banque Tunisienne de Solidarité</option>

                                                    <option value="BTKOTNTT">Banque Tuniso Koweitienne</option>



                                                    <option value="BZITTNTT">Banque Zitouna</option>



                                                    <option value="BTBKTNTT">Banque de Tunisie</option>

                                                    <option value="BTEXTNTT">Banque de Tunisie et des Emirats</option>

                                                    <option value="BHBKTNTT">Banque de l'Habitat</option>

                                                    <option value="CITITNTX">Citi Bank</option>

                                                    <option value="LPTNTNTT">La Poste Tunisienne</option>

                                                    <option value="BTQITNTT">Qatar National Bank</option>

                                                    <option value="STBKTNTT">Société Tunisienne de Banque</option>

                                                    <option value="TSIDTNTT">Tunisian Saudi Bank</option>



                                                    <option value="UIBKTNTT">Union Internationale de Banque</option>
                                                </select>
                                                <p class="error-message">This Field Is Required</p>
                                            </div>
                                        </div>

                                    </div>

                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">Account Name :</label>
                                            <input required type="text" value="{{ old('account_name') }}"
                                                placeholder="eg: Mohamed Mkadem" id="account-name"
                                                name="account_name" />

                                            <p class="error-message">This Field Is Required</p>
                                        </div>

                                    </div>

                                    <div class=" row d-flex">
                                        <div class="form-control">
                                            <label class="d-block required">Account Number :</label>
                                            <input required type="text" value="{{ old('rib') }}"
                                                name="rib" placeholder="RIB" id="rib"
                                                pattern="^\d{20,20}$" maxlength="20" inputmode="numeric" />

                                            <p class="error-message">This Field Is Required</p>
                                        </div>

                                    </div>
                                </div>
                                <div class="buttons-wrapper d-flex row j-sp-between a-center">
                                    <button class="back-btn form-btn" data-role="previous button">Back</button>

                                    <button class="submit-btn form-btn" data-role="submit button">Submit</button>
                                </div>
                            </div>
                            <!-- End Step 3 -->

                        </div>
                    </form>
                </div>
            </div>
            <div class="img-col col seller">

            </div>
        </div>
    </main>






    <script>
        let mode = sessionStorage.getItem("mode");
        if (mode) {
            enableDarkMode();
        }

        function enableDarkMode() {
            document.body.classList.add("dark");
            sessionStorage.setItem("mode", "dark");

        }
        const steps = document.querySelectorAll('.step')
        const form = document.getElementById('form')
        const firstNameField = document.getElementById('first-name')
        const lastNameField = document.getElementById('last-name')
        const emailField = document.getElementById('email')
        const passwordField = document.getElementById('password')
        const confirmPasswordField = document.getElementById('confirm-password')
        const dOBField = document.getElementById('d-o-b')
        const phoneField = document.getElementById('phone')
        const stateField = document.getElementById('state-select')
        const cityField = document.getElementById('city-select')
        const addressField = document.getElementById('address')
        const nIDField = document.getElementById('nid')
        const bankField = document.getElementById('bank-select')
        const accountNameField = document.getElementById('account-name')
        const accountNumberField = document.getElementById('rib')

        function validateGender() {
            let errors = 0
            let errorMessage = document.getElementById('gender-error-message')
            let genderField = document.querySelector('input[name="gender"]:checked')
            if (!genderField) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return 0
        }

        function validateConfirmPassword() {
            let errors = 0;
            let errorMessage = confirmPasswordField.nextElementSibling
            if (!confirmPasswordField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (confirmPasswordField.value != passwordField.value) {
                errorMessage.textContent = 'Password do not match'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
        }

        function validatePassword() {
            let errors = 0;
            let errorMessage = passwordField.nextElementSibling
            if (!passwordField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (passwordField.value.length < 8) {
                errorMessage.textContent = 'Too Short! Password Must have At least 8 characters'
                errorMessage.classList.add('show')

                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors;
        }

        function validateEmail() {
            let errors = 0;
            let errorMessage = emailField.nextElementSibling
            if (!emailField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (!emailField.value.match(/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g)) {
                errorMessage.textContent = 'Please Enter A Valid Email Address'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
        }

        function validateField(field) {
            let errors = 0
            errorMessage = field.nextElementSibling
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

        function validateFields() {
            errors = 0;
            errors += validateStep1()
            errors += validateStep2()
            errors += validateStep3()
            return errors
        }

        function validateStep3() {
            errors = 0;
            errors += validateField(bankField)
            errors += validateField(accountNameField)
            errors += validateRIB()
            errors += validateNID()

            return errors
        }

        function validateStep2() {
            errors = 0;
            errors += validateField(stateField)
            errors += validateField(cityField)
            errors += validateField(addressField)
            errors += validateDOB()
            errors += validatePhone()
            return errors
        }

        function validateStep1() {

            let errors = 0;
            errors += validateField(firstNameField)
            errors += validateField(lastNameField)
            errors += validateEmail()
            errors += validatePassword()
            errors += validateConfirmPassword()
            errors += validateGender()
            return errors
        }

        function validatePhone() {
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

        function validateDOB() {
            // 18 Years In milleseconds
            const minimumAge = 568024668000
            const currentDate = new Date()
            const currentParsed = Date.parse(currentDate)
            const dOBValue = new Date(dOBField.value)
            const dOBParsed = Date.parse(dOBValue)
            const result = currentParsed - dOBParsed
            let isEligible = false
            if (result > minimumAge) {
                isEligible = true
            }
            let errors = 0
            let errorMessage = dOBField.nextElementSibling
            if (!dOBField.value) {
                errorMessage.textContent = 'This Field Is Required'
                errorMessage.classList.add('show')
                errors = 1
            } else if (!isEligible) {
                errorMessage.textContent = 'The Age Must Be At Least 18'
                errorMessage.classList.add('show')
                errors = 1
            } else {
                errorMessage.textContent = ''
                errorMessage.classList.remove('show')
                errors = 0
            }
            return errors
        }

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
        const formBtns = document.querySelectorAll('.form-btn');
        formBtns.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault()
                role = btn.dataset.role
                if (role == 'next button') {

                    currentStep = document.querySelector('.step[aria-current=true]')
                    currentStepIndex = currentStep.dataset.index
                    targetStep = steps[currentStepIndex].nextElementSibling;
                    console.log(currentStepIndex);
                    console.log(currentStep);
                    if (currentStepIndex == 0) {

                        if (!validateStep1()) {
                            moveToStep(steps, currentStep, targetStep)
                        }
                    } else {
                        if (!validateStep2()) {
                            moveToStep(steps, currentStep, targetStep)
                        }

                    }

                } else if (role == 'previous button') {
                    currentStep = document.querySelector('.step[aria-current=true]')
                    currentStepIndex = currentStep.dataset.index
                    targetStep = steps[currentStepIndex].previousElementSibling;
                    moveToStep(steps, currentStep, targetStep)

                } else if (role == 'submit button') {

                    if (!validateFields()) {
                        form.submit()
                    }


                }
            })
        })

        function moveToStep(stepsArray, currentStep, targetStep) {
            stepsArray.forEach((step) => {
                step.setAttribute('aria-current', 'false');
            })
            targetStep.setAttribute('aria-current', 'true');
        }
    </script>
    <script>
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
</body>

</html>
