@extends('layouts.Seller')

@push('title')
    <title>Pickup | Store Details</title>
@endpush
@section('content')
    @if ($store)
        <section class="content" id="content">
            <!-- Start Starter Header -->
            <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
                <h1>{{ $store->name }}</h1>
                <ul class="horizontal-actions-holder gap-1 wrap d-flex  j-center a-center">
                    @if ($store->status != 'banned')
                        <li>
                            <a href="{{ route('seller.stores.edit', $store->username) }}" class="editBtn"> <i
                                    class="fa-light fa-pen"></i>
                                Edit</a>
                        </li>
                        @if ($store->status == 'maintenance')
                            <li>
                                <button class="deleteBtn delete-button">Disable Maintenance Mode</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('seller.stores.disableMaintenance', $store->id) }}"
                                        method="post" class="modal t-center confirm-form">
                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-info"></i>
                                        <p>Are You Sure You Want To Disable The Maintenance Mode ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @elseif($store->status == 'published')
                            <li>
                                <button class="deleteBtn delete-button">Enable Maintenance Mode</button>

                                <div class="modal-holder ">
                                    <form action="{{ route('seller.stores.enableMaintenance', 240404) }}" method="post"
                                        {{-- <form action="{{ route('seller.stores.enableMaintenance', $store->id) }}" method="post" --}} class="modal t-center confirm-form">
                                        @csrf
                                        @method('PATCH')
                                        <i class=" fa-light fa-info"></i>
                                        <p>Are You Sure You Want To Enable The Maintenance Mode ?</p>
                                        <div class="buttons d-flex j-center a-center">
                                            <button class="cancelBtn">Cancel</button>
                                            <button class="confirmBtn">Yes</button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                        @endif
                    @else
                    @endif
                </ul>
            </div>
            <!-- End Starter Header -->
            @include('components.errors-alert')
            @include('components.session-errors-alert')
            @include('components.success-alert')

            <!-- Start Header -->
            <div class="store-header-wrapper">


                <div class="store-top-header radius-10 holder p-1  gap-1 d-flex j-sp-between a-center wrap ">
                    <p class="decision p-span">Status: <span>{{ Str::ucfirst($store->status) }}</span></p>
                    <p class="rate"><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
                </div>

                <div class="main-store-header holder p-0-5 radius-10">
                    <div class="cover-holder" style="background-image: url({{ asset('storage/' . $store->cover_photo) }})">
                    </div>
                    <div class="main-info-holder">
                        <div class="img-holder">
                            <img src="{{ asset('storage/' . $store->photo) }}" alt="">
                        </div>
                        <div class="basic-info">
                            <h1 class="store-name">{{ $store->name }}</h1>
                            <p class="store-username-sector">{{ '@' . $store->username }} - {{ $store->sector->name }}</p>
                            <p class="expiry-date ">Expires on :
                                {{ $store->expiry_date ? $store->expiry_date : 'Undefined' }}</p>
                        </div>
                        <div class="additional-info d-flex j-sp-between a-center wrap gap-0-5">
                            <p class="followers-count ">
                                {{ $store->followers != 1 ? $store->followers . ' Followers' : '1 Follower' }} </p>
                            <a href="../Admin/preview_store_home.html" class="preview-btn">Preview</a>

                        </div>
                    </div>
                </div>


            </div>
            <!-- End Header -->
            <div class="store-content  m-block-2">
                <div class="main-grid">
                    <!-- Start Sidebar -->
                    <div class="info-sidebar holder p-1 radius-10">
                        <!-- Start Sidebar Header -->
                        <div class="info-sidebar-header d-flex j-sp-between a-center gap-0-5 wrap">
                            <h3 class="store-secondary-title">General Info</h3>

                        </div>
                        <!-- Start Sidebar Header -->
                        <div class="info-sidebar-body" id="info-sidebar-body">
                            <!-- Start Info -->
                            <div class="info ">
                                <h4 class="grid-title bio"><i class="fa-light fa-circle-info"></i> Bio</h4>

                                {!! $store->bio !!}
                            </div>
                            <!-- End Info -->
                            <!-- End Info -->
                            <div class="info ">
                                <h4 class="grid-title joined"><i class="fa-light fa-dollar-sign"></i> {{ $store->balance }}
                                    DT
                                </h4>

                            </div>
                            <!-- End Info -->
                            <!-- Start Info -->
                            <div class="info ">
                                <h4 class="grid-title address"><i class="fa-light fa-location"></i>
                                    {{ $store->state_city }}
                                </h4>
                                <p class="full-address">{{ $store->address }}</p>

                            </div>
                            <!-- End Info -->
                            <div class="info phone">
                                <h4 class="grid-title phone"><i class="fa-light fa-phone"></i> {{ $store->phone }}</h4>

                            </div>
                            <!-- End Info -->
                            <!-- End Info -->
                            <div class="info phone">
                                <h4 class="grid-title joined"><i class="fa-light fa-timer"></i>
                                    {{ \Carbon\Carbon::parse($store->created_at)->format('M jS Y') }}
                                </h4>

                            </div>
                            <!-- End Info -->



                        </div>
                    </div>
                    <!-- End Sidebar -->
                    <!-- Start Opening Hours -->
                    <div class="opening-hours-content holder radius-10 p-1">
                        <!-- Start opening-hours-content Header -->
                        <div class="opening-hours-header ">
                            <h2 class="mb-1">Opening Hours</h2>

                        </div>
                        <!-- End opening-hours-content Header -->
                        <!-- Start opening-hours-content Body -->
                        <div class="opening-hours-content-body">
                            <form action="" method="post">
                                <div class="form-row">

                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Monday</h3>

                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element"
                                                    value="{{ $store->openingHours[0]->opening_time }}"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[0]->closing_time }}"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->
                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Tuesday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[1]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[1]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->


                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Wednesday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[2]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[2]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->
                                    <!-- Start Day -->

                                    <div class="day">
                                        <h3>Thursday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[3]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[3]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->


                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Friday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[4]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[4]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->

                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Saturday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[5]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[5]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- End Day -->

                                    <!-- Start Day -->
                                    <div class="day">
                                        <h3>Sunday</h3>
                                        <div class="hours-holder">
                                            <div class="hour">
                                                <label for="" class="form-label">Open</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[6]->opening_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>
                                            <div class="hour">
                                                <label for="" class="form-label">Close</label>
                                                <input type="time" class="form-element" readonly
                                                    value="{{ $store->openingHours[6]->closing_time }}" name="myTime"
                                                    pattern="([01][0-9]|2[0-3]):[0-5][0-9]" required>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- End Day -->

                                </div>
                            </form>
                        </div>
                        <!-- End opening-hours-content Body -->
                    </div>
                    <!-- End Opening Hours -->
                </div>
            </div>




            <div class="not-found-holder ">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p class="mb-1">You Didn't Add Any Store yet</p>
                    <a href="store_create.html" class="activate-button ">Create Store</a>
                </div>
            </div>

        </section>
    @else
        'not Found'
    @endif
@endsection

@push('scripts')
    @include('components.inc_modals-js')
@endpush
