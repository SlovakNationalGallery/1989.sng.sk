@extends('layouts.master')
@section('page_title', "$topic->name • Čas-opis 1989")
@section('page_description', Str::limit(strip_tags(parsedown($topic->description)), 300))
@section('og_image', asset($topic->cover_image))
@section('body-class', 'topic')
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
            <div class="container pt-2 pt-md-3">
                <a href="/" id="logo-top-nav" class="text-decoration-none" title="Prejsť na úvodnú stránku">
                    <h3>ČAS-OPIS <span class="year">1989</span></h3>
                </a>
                <div id="title-container">
                    <h1 id="title" class="mt-5">{{ $topic->name }}</h1>
                </div>
                <div id="share-button-placeholder"></div>
            </div>
        </div>
        <div id="description-container" class="container position-relative">
            <div class="row">
                <div id="description" class="offset-lg-3 col-lg-6 file-paper text-left pt-4 pr-4 pr-md-5">
                    {!! parsedown($topic->description) !!}
                </div>
            </div>
        </div>
    </div>

    @yield('before-items')

    <div id="items" class="card-columns">
        @yield('items')
    </div>

    <footer>
        <div class="container">
            <div class="row">
                <div id="previous-topic" class="col-md-6 related-topic">
                @if ($previousTopic)
                    <div class="bg-white">
                      <a href="{{ route('topics.show', $previousTopic) }}">
                        <div class="topic-preview" style="background-image: url('{{ asset($previousTopic->cover_image) }}'"></div>
                      </a>
                    </div>
                    <div class="description px-4">
                        <h4>Súvisiace</h4>
                        <a href="{{ route('topics.show', $previousTopic) }}" class="text-white"><h3 class="p-0">{{ $previousTopic->name }}</h3></a>
                        <p style="color: white">{{ $topic->previous_topic_blurb }}</p>
                    </div>
                @endif
                </div>
                <div id="next-topic" class="col-md-6 related-topic">
                @if ($nextTopic)
                    <div class="bg-white">
                      <a href="{{ route('topics.show', $nextTopic) }}">
                        <div class="topic-preview" style="background-image: url('{{ asset($nextTopic->cover_image) }}'"></div>
                      </a>
                    </div>
                    <div class="description px-4">
                        <h4>Súvisiace</h4>
                        <a href="{{ route('topics.show', $nextTopic) }}" class="text-white"><h3 class="p-0">{{ $nextTopic->name }}</h3></a>
                        <p style="color: white">{{ $topic->next_topic_blurb }}</p>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </footer>
</div>
@include('components.footer')
@endsection

