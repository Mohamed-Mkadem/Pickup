                    <!-- Start Header -->
                    <div class="store-header-wrapper">
                        <div class="store-top-header radius-10 holder p-1  gap-1 d-flex j-sp-between a-center wrap ">
                            <p class="decision p-span">Status : <span>{{ $store->status }}</span></p>
                            <p class="rate"><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
                        </div>

                        <div class="main-store-header holder p-0-5 radius-10">
                            <div class="cover-holder"
                                style="background-image: url({{ asset('storage/' . $store->cover_photo) }})"></div>
                            <div class="main-info-holder">
                                <div class="img-holder">
                                    <img src="{{ asset('storage/' . $store->photo) }}" alt="">
                                </div>
                                <div class="basic-info">
                                    <h1 class="store-name">{{ $store->name }}</h1>
                                    <p class="store-username-sector">{{ '@' . $store->username }} -
                                        {{ $store->sector->name }}</p>
                                    <p class="expiry-date ">Expiry Date :
                                        {{ $store->expiry_date ? \Carbon\Carbon::parse($store->expiry_date)->format('M jS Y') : 'Undefined' }}
                                    </p>
                                </div>
                                <div class="additional-info d-flex j-sp-between a-center wrap gap-0-5">
                                    <p class="followers-count ">
                                        {{ $store->followers == 1 ? '1 Follower' : $store->followers . ' Followers' }}
                                    </p>
                                    {{-- <a href="" class="preview-btn">Preview</a> --}}
                                </div>
                            </div>
                        </div>

                        <div class="holder navigation-menu-holder  d-flex j-sp-between a-center radius-10">
                            <button id="nav-toggle" class="icon-btn " aria-controls="#store-navigation-menu"><i
                                    class="fa-light fa-bars"></i></button>
                            <nav id="store-navigation-menu" class="">
                                <ul>
                                    <button id="close-main-navigation" aria-controls="store-navigation-menu"><i
                                            class="fa-solid fa-close"></i></button>
                                    <li><a href="{{ route('admin.store.home', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/home*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-home"></i>
                                            Home</a>
                                    </li>
                                    <li><a href="{{ route('admin.store.owner', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/owner*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-user"></i> Owner</a></li>
                                    <li><a href="{{ route('admin.store.orders', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/orders*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-cart-arrow-down"></i>
                                            Orders</a></li>

                                    <li><a href="{{ route('admin.store.sales', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/sales*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-hand-holding-dollar"></i>
                                            Sales</a></li>
                                    <li><a href="{{ route('admin.store.transfers', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/transfers*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-arrow-right-arrow-left"></i>
                                            Transfers</a></li>
                                    <li><a href="{{ route('admin.store.reviews', $store->username) }}"
                                            class="{{ request()->is('admin/store/*/reviews*') ? 'active' : '' }}"> <i
                                                class="fa-light fa-arrow-right-arrow-left"></i>
                                            Reviews</a></li>


                                </ul>
                            </nav>
                            <button class="actions-controller"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <ul class="actions-holder ">
                                <li>
                                    <button class="unPublishBtn">Unpublish</button>
                                    <div class="modal-holder ">
                                        <form action="" method="post" class="modal t-center confirm-form">
                                            <i class=" fa-light fa-trash"></i>
                                            <p>Are You Sure You Want To Unpublish This Store ?</p>
                                            <div class="buttons d-flex j-center a-center">
                                                <button class="cancelBtn">Cancel</button>
                                                <button class="confirmBtn">Yes</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                                <li>
                                    <button class="publishBtn">Publish</button>
                                    <div class="modal-holder">
                                        <div class=" form-modal modal">
                                            <div class="modal-header d-flex j-sp-between a-center">
                                                <h2>Publish Store </h2>
                                                <button class="close-modal-holder-btn"><i
                                                        class="fa-light fa-close"></i></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Start Form -->
                                                <form action="#" method="post" id="publish-form">
                                                    <div class="form-control">
                                                        <label for="publish-date" class="d-block required form-label">
                                                            Publish Untill :
                                                        </label>
                                                        <div class="select-box">
                                                            <select name="" id="period-select"
                                                                class="form-element">

                                                                <option value="day" aria-checked="true" checked>One
                                                                    Day
                                                                </option>
                                                                <option value="week" aria-checked="false">One Week
                                                                </option>
                                                                <option value="month" aria-checked="false">One Month
                                                                </option>
                                                                <option value="1 year" aria-checked="false">One Year
                                                                </option>
                                                            </select>
                                                            <p class="error-message" id="period-error-message">This
                                                                Field Is
                                                                Required</p>
                                                        </div>
                                                    </div>

                                                    <div class="form-control d-flex j-end">
                                                        <button type="submit" class="submit-btn">Publish</button>
                                                    </div>
                                                </form>
                                                <!-- End Form -->

                                            </div>
                                        </div>

                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <!-- End Header -->
