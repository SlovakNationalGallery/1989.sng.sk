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
    <calendar :available-days='{{ $days }}' start="{{ $days->first()->toDateString() }}"
        end="{{ $days->last()->toDateString() }}" today="{{ $today }}" start-at="{{ $date }}"></calendar>
</div>
<transition-page>
    <router-view></router-view>
</transition-page>

@include('components.newsletter')

@include('components.letters_expositions')

@include('components.footer', ['topics' => App\Models\Topic::orderBy('name', 'asc')->get()->groupBy('category')])

@stop