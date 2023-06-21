@extends('layouts.Seller')

@push('title')
    <title>Pickup | Home</title>
@endpush
@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
@endsection

@push('scripts')
@endpush
