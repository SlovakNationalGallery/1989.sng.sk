@extends('layouts.master')

@section('title', trans('intro.title'))

@push('styles')

<style>
    body {
        background-image: url("{{asset('/images/intro/BG-0' . random_int(1, 4) . '.jpg') }}");
        background-attachment: fixed;
        background-size: cover;
        background-position: top center;
    }

</style>
@endpush

@section('content')
@include('components.header')
<div id="calendar" class="container">
    <calendar
        start-date="{{ $startDate }}"
        end-date="{{ $endDate }}"
        active-dates-start="{{ $activeDatesStart }}"
        active-dates-end="{{ $activeDatesEnd }}"
        default-date="{{ $selected }}"
        today="{{ $today }}"
    ></calendar>
</div>
<transition-page>
    <router-view></router-view>
</transition-page>

@include('components.newsletter')

@include('components.letters_expositions')

@include('components.footer', [
    'with_credits' => true
    ]
);

@stop