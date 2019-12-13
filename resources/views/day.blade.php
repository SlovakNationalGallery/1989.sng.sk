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

.sticky-inner {
    background-color: rgba(0, 0, 0, 0.0);
    transition: background-color .2s ease-in-out;
}

.is-affixed > .sticky-inner {
    background-color: rgba(0, 0, 0, 0.7);
    transition: background-color .5s ease-in-out;
    z-index: 10;
}
.is-affixed .buttons {
    display: none;
}
</style>
@endpush

@section('content')
@include('components.header')
<div data-v-sticky-container>
    <div v-sticky>
        <div data-v-sticky-inner class="sticky-inner py-2">
            <calendar
                start-date="{{ $startDate }}"
                end-date="{{ $endDate }}"
                active-dates-start="{{ $activeDatesStart }}"
                active-dates-end="{{ $activeDatesEnd }}"
                default-date="{{ $selected }}"
                today="{{ $today }}"
            >
            </calendar>
        </div>
    </div>
    <router-view></router-view>
</div>

@include('components.newsletter')

@include('components.letters_expositions')

@include('components.footer', [
    'with_credits' => true
    ]
);

@stop
