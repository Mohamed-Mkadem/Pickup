@extends('layouts.Seller')

@push('title')
    <title>Pickup | Verification Requests</title>
@endpush


@section('content')
    <section class="content" id="content">
        <!-- Start Starter Header -->
        <div class="starter-header d-flex a-center j-sp-between col" id="starter-header">
            <h1>Veficiation Requests</h1>
            <!-- Start Link  -->
            <a href="{{ route('seller.verification-requests.create') }}" class="header-btn d-block add-btn">
                <i class="fa-light fa-plus"></i>
                <span>Add Request</span>
            </a>
            <!-- End Link  -->


        </div>
        <!-- End Starter Header -->
        @include('components.session-errors-alert')
        @if ($verificationRequests->count() > 0)
            <div class="results">
                <h2 class="t-left">Results</h2>
                <!-- Start Results Holder -->

                <div class=" main-holder">
                    <div class="table-responsive seller-verification-requests">
                        <table>

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date </th>
                                    <th>Status </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($verificationRequests as $request)
                                    <tr>
                                        <td><a
                                                href="{{ route('seller.verification-requests.show', $request->id) }}">#{{ $request->id }}</a>
                                        </td>

                                        <td>{{ \Carbon\Carbon::parse($request->created_at)->format('M jS Y') }}</td>
                                        <td class="status {{ $request->status }}"><span>{{ $request->status }}</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- End Results Holder -->


                <!-- Start Pagination -->
                {{ $verificationRequests->appends(request()->input())->links() }}
                <!-- End Pagination -->

            </div>
            <!-- End Results -->
        @else
            <!-- Start Not found -->
            <div class="not-found-holder show">
                <div class="wrapper">
                    <i class="fa-light fa-circle-info"></i>
                    <p>No Results Found</p>
                </div>
            </div>
            <!-- End Not found -->
        @endif
        <!-- End Filters -->
    </section>
@endsection

@push('scripts')
@endpush
