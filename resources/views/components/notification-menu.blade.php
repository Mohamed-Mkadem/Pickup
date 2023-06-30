                        <div class="dropdown-holder">
                            <button id="notifications-handler" data-count="{{ $unreadCount }}"
                                class="top-bar-btn dropdown-toggle {{ $unreadCount != 0 ? 'has-notifications' : '' }}"
                                aria-pressed="false">
                                <i class="fa-light fa-bell"></i>
                            </button>
                            <div class="dropdown-menu notifications-dropdown ">
                                <h4>Notifications</h4>
                                <ul class="notifications-wrapper" id="notifications-wrapper">
                                    @if ($notifications->count() > 0)
                                        @foreach ($notifications as $notification)
                                            <!-- Start Notification -->
                                            <li class="notification {{ $notification->unread() ? 'unread' : '' }}">
                                                <img src="{{ asset('storage/' . $notification->data['image']) }}"
                                                    alt="">
                                                <div class="details">
                                                    <p class="notification-body">
                                                        <a
                                                            href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}">
                                                            {{ $notification->data['body'] }}!</a>
                                                    </p>
                                                    <p class="notification-time">
                                                        <i class="fa-light fa-timer"></i>
                                                        {{ $notification->created_at->diffForHumans() }}
                                                    </p>
                                                </div>
                                            </li>
                                            <!-- End Notification -->
                                        @endforeach
                                    @else
                                        <h3 class="t-center mb-1">No Notifications Found</h3>
                                    @endif
                                </ul>
                                @if (Auth::user()->type == 'Admin')
                                    <a href="{{ route('admin.notifications.index') }}"
                                        class="see-all d-block t-center">See All</a>
                                @elseif(Auth::user()->type == 'Seller')
                                    <a href="{{ route('seller.notifications.index') }}"
                                        class="see-all d-block t-center">See All</a>
                                @else
                                    <a href="{{ route('client.notifications.index') }}"
                                        class="see-all d-block t-center">See All</a>
                                @endif
                            </div>

                        </div>
