@extends('layouts.Admin')

@push('title')
    <title>Pickup | Edit Profile</title>
@endpush


@section('content')
    <section class="content" id="content">
        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
            @csrf
        </form>
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
        {{-- @if ($errors->has('updatePassword'))
            <ul class="alert alert-error ">
                @foreach ($errors->updatePassword->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        @endif --}}
        @if (session()->has('success'))
            {
            <div class="alert alert-success">{{ session()->get('success') }}</div>
            }
        @endif

        @if (session('status') === 'password-updated')
            <div class="alert alert-success mb-1">{{ session()->get('status') }}</div>
        @endif

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div class="mb-2">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif

        <form action="{{ route('admin.profile.update') }}" method="post" id="general-info-form"
            enctype="multipart/form-data">

            @csrf
            @method('PATCH')


            <div class="holder radius-10 p-1 mb-2">
                <div class="form-control">
                    <label for="" class="form-label ">Avatar </label>
                    <div class="drop-zone form-element">
                        <label for="avatar-image" class="drop-zone-label form-label">
                            <i class="fa-light fa-cloud-arrow-up d-block"></i>
                            <p>Drop File Here Or Click To Upload File</p>
                            <p>Allowed Formats are png, jpeg</p>
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
            <div class="holder radius-10 p-1 mb-2">
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $user->first_name) }}"
                            class="form-element" id="f-name-input" placeholder="eg: Mohamed" value="Mohamed">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                            class="form-element" id="l-name-input" placeholder="eg: Mkadem" value="Mkadem">
                        <p class="error-message">This Field Is Required</p>
                    </div>

                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-element"
                            id="email-input" placeholder="eg: Mohamed@gmail.com" value="mkadem@gmail.com">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label for="" class="form-label">Phone</label>
                        <input type="number" name="phone" value="{{ old('phone', $user->phone) }}" class="form-element"
                            id="phone-input" placeholder="eg: 25412145" value="25410254" maxlength="8" inputmode="numeric">

                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label class="form-label">Gender :</label>
                        <div class="select-box">
                            <select name="gender" id="gender-select" class="form-element">
                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>
                                    Male
                                </option>
                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>
                                    Female</option>
                            </select>
                        </div>
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
                                    @foreach ($user->city->state->cities as $city)
                                        <option value="{{ $city->id }}"
                                            @if ($city->id == $user->city_id) selected @endif>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                    }
                                @endif
                            </select>
                        </div>
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-control">
                        <label for="" class="form-label">Address</label>
                        <input type="text" name="address" value="{{ old('address', $user->address) }}"
                            class="form-element" id="address-input" placeholder="eg: 25 Awesome Street Name"
                            value="25 Awesome Street Name">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                    <div class="form-control">
                        <label class=" form-label">Date Of Birth :</label>
                        <input type="date" name="d_o_b" value="{{ old('d_o_b', $user->d_o_b) }}" id="dob-input"
                            class="form-element blue">
                        <p class="error-message">This Field Is Required</p>
                    </div>
                </div>
                <div class="buttons d-flex j-end gap-1 wrap mt-1">
                    <button type="reset" class="resetBtn">Reset</button>
                    <button type="submit" class="submitBtn">Save</button>

                </div>
            </div>
            <!-- </div> -->


        </form>
        <form action="{{ route('password.update') }}" method="post" id="password-form">
            @csrf
            @method('PUT')
            <div class="holder radius-10 p-1" style=" width: min(500px, 100%);">
                <h2 class="mb-1 form-holder-title">Password</h2>
                <div class="form-control">
                    <label for="" class="form-label required">Current Password</label>
                    <input type="password" class="form-element" placeholder="Type The Current Password"
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
                    <input type="password" class="form-element" placeholder="Type A Strong Password" name="password"
                        id="new-password">
                    @if ($errors->updatePassword)
                        @foreach ($errors->updatePassword->get('password') as $message)
                            <p class="error-message show"> {{ $message }} </p>
                        @endforeach
                    @endif
                    <p class="error-message">This Field Is Required</p>
                </div>
                <div class="form-control">
                    <label for="" class="form-label required">Confirm Password</label>
                    <input type="password" class="form-element" placeholder="Confirtm Password"
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
    </section>
@endsection


@push('scripts')
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
