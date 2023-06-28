@extends('layouts.Admin')

@push('title')
    <title>Pickup | Vouchers </title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
    <section class="content" id="content">


        <!-- Start Notificatio Holder -->
        <div class="results">

            <div class="main-holder notifications-holder">


                <h1>Notifications</h1>

                <form action="" method="get">

                    <div class="statuses-holder  form-row sm  ">
                        <div class="status form-element">
                            <label for="all">All</label>
                            <input type="radio" id="all" checked name="status" value="all">
                        </div>
                        <div class="status form-element">
                            <label for="read">Read</label>
                            <input type="radio" id="read" name="status" value="read">
                        </div>
                        <div class="status form-element">
                            <label for="unread">Unread</label>
                            <input type="radio" id="unread" name="status" value="unread">
                        </div>

                    </div>
                </form>
                <ul class="notifications-wrapper">
                    @foreach ($notifications as $notification)
                        <!-- Start Notification -->
                        <li
                            class="notification 
                        {{ $notification->unread() ? 'unread' : '' }}
                        ">
                            <img src="{{ asset('storage/' . $notification->data['image']) }}" alt="">
                            <div class="details">
                                <p class="notification-body">
                                    {{ $notification->data['body'] }}
                                </p>
                                <p class="notification-time">
                                    <i class="fa-light fa-timer"></i> {{ $notification->created_at->diffForHumans() }}
                                </p>
                                <a href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}"></a>
                            </div>
                        </li>
                        <!-- End Notification -->
                    @endforeach
                </ul>
            </div>

            <!-- Start Pagination -->
            {!! $notifications->appends(request()->input())->links() !!}
            <!-- End Pagination -->

        </div>
        <!-- End Notificatio Holder -->
    </section>
@endsection

@push('scripts')
@endpush
