@extends('layouts.Admin')

@push('title')
    <title>Pickup | Notifications </title>
@endpush
@section('content')
    <section class="content" id="content">

        @include('components.errors-alert')
        @include('components.session-errors-alert')
        @include('components.success-alert')
        <!-- Start Notificatio Holder -->
        <div class="results">


            <div class=" notifications-holder">
                <div class="holder p-1 radius-10">
                    <h1 class="mb-0-5">Filter</h1>
                    <form action="{{ route('admin.notifications.filter') }}" method="get">

                        <div class="statuses-holder  form-row sm  ">
                            <div class="status form-element">
                                <label for="all">All</label>
                                <input type="radio" id="all" {{ request()->status == 'all' ? 'checked' : '' }}
                                    checked name="status" value="all">
                            </div>
                            <div class="status form-element">
                                <label for="read">Read</label>
                                <input type="radio" id="read" {{ request()->status == 'read' ? 'checked' : '' }}
                                    name="status" value="read">
                            </div>
                            <div class="status form-element">
                                <label for="unread">Unread</label>
                                <input type="radio" id="unread" {{ request()->status == 'unread' ? 'checked' : '' }}
                                    name="status" value="unread">
                            </div>

                        </div>
                        <div class="buttons d-flex j-end mt-1">
                            <button class="submitBtn" type="submit">Filter</button>
                        </div>
                    </form>
                </div>
                <div class="notifications-container main-holder">


                    <h1 class="mb-1">Notifications</h1>


                    @if ($notifications->count() > 0)
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
                                            <i class="fa-light fa-timer"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                        <a
                                            href="{{ $notification->data['url'] }}?notification_id={{ $notification->id }}"></a>
                                    </div>
                                </li>
                                <!-- End Notification -->
                            @endforeach
                        </ul>
                    @else
                        <h3 class="t-center">No Notifications Found</h3>
                    @endif
                </div>
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
