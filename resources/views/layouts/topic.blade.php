@extends('layouts.master')
@section('page_title', "$topic->name • Čas-opis 1989")
@section('og_image', asset($topic->cover_image))
@push('styles')
<style>
    #topic .cover-image {
        background-image:
            linear-gradient(
                rgba(0, 0, 0, 0.35),
                rgba(0, 0, 0, 0.35)
            ),
            url("/{{ $topic->cover_image }}");
    }

    #previous-topic .image {
        background-image: url("/{{ $previousTopic->cover_image  ?? '' }}");
    }
    #next-topic .image {
        background-image: url("/{{ $nextTopic->cover_image ?? '' }}");
    }

    /* TODO -- replace with a share button */
    #share-button-placeholder {
        height: 40px;
    }

</style>
@endpush

@section('content')
<div id="topic">
    <div class="header text-center">
        <div class="cover-image">
            <div class="container pt-2">
                <a href="/" title="Prejsť na úvodnú stránku"><h3 id="top-nav">ČAS-OPIS <span class="year">1989</span></h3></a>
                <div id="title-container">
                    <h1 id="title" class="mt-5">{{ $topic->name }}</h1>
                </div>
                <div id="share-button-placeholder"></div>
            </div>
        </div>
        <div id="description-container" class="container position-relative">
            <div class="row">
                <div id="description" class="offset-lg-3 col-lg-6 file-paper text-left pt-4 pr-5">
                    {!! parsedown($topic->description) !!}
                </div>
            </div>
        </div>
    </div>

    @yield('before-items')

    <div id="items">
        @yield('items')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div id="previous-topic" class="col-md-6 related-topic">
                @if ($previousTopic)
                    @if ($previousTopic->cover_image)
                        <a href="{{ route('topics.show', $previousTopic) }}">
                            <div class="image-container"><div class="image"></div></div>
                        </a>
                    @else
                        <div class="image-placeholder"></div>
                    @endif
                    <div class="description px-4">
                        <h4>Predchádzajúce</h4>
                        <a href="{{ route('topics.show', $previousTopic) }}"><h3 class="p-0" style="color: white">{{ $previousTopic->name }}</h3></a>
                        <p style="color: white">{{ $topic->previous_topic_blurb }}</p>
                    </div>
                @endif
                </div>
                <div id="next-topic" class="col-md-6 related-topic">
                @if ($nextTopic)
                    @if ($nextTopic->cover_image)
                        <a href="{{ route('topics.show', $nextTopic) }}">
                            <div class="image-container"><div class="image"></div></div>
                        </a>
                    @else
                        <div class="image-placeholder"></div>
                    @endif
                    <div class="description px-4">
                        <h4>Nasledujúce</h4>
                        <a href="{{ route('topics.show', $nextTopic) }}"><h3 class="p-0" style="color: white">{{ $nextTopic->name }}</h3></a>
                        <p style="color: white">{{ $topic->next_topic_blurb }}</p>
                    </div>
                @endif
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="#top" title="Na začiatok stránky" class="jump-to-top"><img src="{{ asset('images/caret-up.svg') }}" alt="šípka hore" /></a>
        </div>
    </footer>
</div>
@endsection
