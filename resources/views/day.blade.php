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
        background-color: rgba(0, 0, 0, 0.9);
        transition: background-color .5s ease-in-out;
    }

</style>
@endpush

@section('content')
@include('components.header')
<div sticky-container>
    <div
        id="calendar"
        class="sticky"
        v-sticky="true"
        sticky-offset="{top: 0, bottom: 30}"
        sticky-side="both"
        on-stick="onStick"
        sticky-z-index="20"
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

@include('components.footer', ['topics' => App\Models\Topic::orderBy('name', 'asc')->get()->groupBy('category')])

@stop