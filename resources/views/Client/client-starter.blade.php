@extends('layouts.Client')

@push('title')
    <title>Pickup | starter</title>
@endpush


@section('content')
    @include('components.errors-alert')
    @include('components.session-errors-alert')
    @include('components.success-alert')
@endsection

@push('scripts')
@endpush
