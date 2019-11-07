@extends('layouts.master')
@section('body-class', 'bg-light topic')

@push('styles')
<style>
    .cover-image {
        background-image: url("@yield('cover-image-url', '')");
        background-attachment: fixed;
        background-size: cover;
        background-position: top center;
        height: 60vh;
        width: 100%;
        position: absolute;
    }
    .container {
        position: relative;
    }
    .description {
        font-size: .9em;
    }
</style>
@endpush

@section('content')
<div class="header text-center">
    <div class="cover-image"></div>
    <div class="container pt-2">
        <h3>ČAS-OPIS 1989</h3>
        <h1 class="mt-4">@yield('topic-title', '')</h1>
        <div class="row">
            <div class="description offset-3 col-6 file-paper text-left pt-5 pr-4">
                @yield('topic-description')
            </div>
        </div>
    </div>
</div>

<div id="items">
    @yield('items')
</div>

@endsection
