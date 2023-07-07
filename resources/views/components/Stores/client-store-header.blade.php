          <!-- Start Header -->
          <div class="store-header-wrapper">

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

                      </div>
                      <div class="additional-info d-flex j-sp-between a-center wrap gap-0-5">
                          <p class="followers-count ">
                              {{ $store->followers == 1 ? '1 Follower' : $store->followers . ' Followers' }}</p>
                          @if (Auth::user()->client->isFollowing($store->id))
                              <form action="{{ route('client.store.unfollow', $store) }}" method="post"
                                  class="following-action">
                                  @csrf
                                  @method('DELETE')
                                  <button class="following " id="un-follow-btn">Unfollow</button>
                              </form>
                          @else
                              <form action="{{ route('client.store.follow', $store) }}" method="post"
                                  class="following-action">
                                  @csrf
                                  <button class="following " id="un-follow-btn">Follow</button>
                              </form>
                          @endif
                      </div>
                  </div>
              </div>

              <div class="holder navigation-menu-holder  d-flex j-sp-between a-center radius-10">
                  <button id="nav-toggle" class="icon-btn " aria-controls="#store-navigation-menu"><i
                          class="fa-light fa-bars"></i></button>
                  <nav id="store-navigation-menu" class="">
                      <ul class="j-start">
                          <button id="close-main-navigation" aria-controls="store-navigation-menu"><i
                                  class="fa-solid fa-close"></i></button>
                          <li><a href="{{ route('client.store.home', $store->username) }}"
                                  class="{{ request()->is('client/store/*/home*') ? 'active' : '' }}">
                                  <i class="fa-light fa-home"></i>
                                  Home</a>
                          </li>
                          <li><a href="{{ route('client.store.products', $store->username) }}"
                                  class="{{ request()->is('client/store/*/product*') ? 'active' : '' }}">
                                  <i class="fa-light fa-box"></i>
                                  Products</a>
                          </li>
                          <li><a href="{{ route('client.store.orders', $store->username) }}"
                                  class="{{ request()->is('client/store/*/orders*') ? 'active' : '' }}">
                                  <i class="fa-light fa-cart-arrow-down">
                                  </i>
                                  Orders</a>
                          </li>

                          <li><a href="{{ route('client.store.reviews', $store->username) }}"
                                  class="{{ request()->is('client/store/*/reviews*') ? 'active' : '' }}">
                                  <i class="fa-light fa-star"></i>
                                  Reviews</a>
                          </li>
                          <li><a href="{{ route('client.store.cart', $store->username) }}"
                                  class="{{ request()->is('client/store/*/cart*') ? 'active' : '' }}">
                                  <i class="fa-light fa-bag-shopping"></i>
                                  Cart</a>
                          </li>


                      </ul>
                  </nav>
                  <p class="rate"><i class="fa-light fa-star"></i> {{ $store->rate }}%</p>
              </div>
          </div>
          <!-- End Header -->
