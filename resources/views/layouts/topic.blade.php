@extends('layouts.master')

@push('styles')
<style>
    body {
        background-color: $gray-light;
    }
    .cover-image {
        background-image: url("/{{ $topic->cover_image }}");
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
<div class="topic">
    <div class="header text-center">
        <div class="cover-image"></div>
        <div class="container pt-2">
            <h3>ČAS-OPIS 1989</h3>
            <h1 class="mt-4">{{ $topic->name }}</h1>
            <div class="row">
                <div class="description offset-3 col-6 file-paper text-left pt-5 pr-5">
                    {!! parsedown($topic->description) !!}
                </div>
            </div>
        </div>
    </div>


    <div id="items">
        @yield('items')
    </div>
</div>
@endsection
