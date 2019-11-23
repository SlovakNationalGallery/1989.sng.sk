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

    .sticky {
        background-color: rgba(0, 0, 0, 0.0);
        transition: background-color .2s ease-in-out;

    }

    .top-sticky {
        background-color: rgba(0, 0, 0, 0.7);
        transition: background-color .5s ease-in-out;
    }

    .top-sticky .buttons {
        display: none;
    }


</style>
@endpush

@section('content')
@include('components.header')
<div sticky-container>
    <div
        class="sticky py-2"
        v-sticky
        sticky-offset="offset"
        sticky-side="both"
    >
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
    <router-view></router-view>
</div>

@include('components.newsletter')

@include('components.letters_expositions')

@include('components.footer', [
    'with_credits' => true
    ]
);

@stop
