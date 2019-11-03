@extends('layouts.master')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />

    <style>

        .drag-and-resize {
          box-sizing: border-box;
          z-index: 50;
        }


        #items div.photo img {
          width: 100%;
          height: 100%;
          -webkit-transition: opacity .2s ease-in-out;
          -moz-transition: opacity .2s ease-in-out;
          transition: opacity .2s ease-in-out;

        }

        #items div.photo a:hover img {
          opacity: 0.9;
        }

        #items div.photo {
          background-color: #fff;
          position: absolute;
          z-index: 10;
        }

        #items div.photo button {
          position: absolute;
          top: 7px;
          right: 10px;
        }

        @media(max-width: 720px) {

            .navbar-brand svg {
              width: 150px;
              height: 150px;
            }

            .navbar-transparent .navbar-nav>li {
                padding: 5px 5px !important;
                position: static;
                text-align: center;
            }

            .navbar-transparent  .navbar-collapse ul.navbar-left {
              margin-top: 130px;
            }

            #items {
              margin-top: 150px;
              padding: 30px;
            }

            #items .photo-container {
              height: auto !important;
            }

            #items div.photo {
              margin: 0 0 30px 0 !important;
              width: 100% !important;
              height: auto !important;
              position: static !important;
              left: 0 !important;
              top: 0 !important;
            }
        }


        /* magnific popup */

        .mfp-with-zoom .mfp-container,
        .mfp-with-zoom.mfp-bg {
          opacity: 0;
          -webkit-backface-visibility: hidden;
          /* ideally, transition speed should match zoom duration */
          -webkit-transition: all 0.3s ease-out;
          -moz-transition: all 0.3s ease-out;
          -o-transition: all 0.3s ease-out;
          transition: all 0.3s ease-out;
        }

        .mfp-with-zoom.mfp-ready .mfp-container {
            opacity: 1;
        }
        .mfp-with-zoom.mfp-ready.mfp-bg {
            opacity: 0.8;
        }

        .mfp-with-zoom.mfp-removing .mfp-container,
        .mfp-with-zoom.mfp-removing.mfp-bg {
          opacity: 0;
        }

        p.authors {
          margin-top: 30px;
          font-size: 12px !important;
        }

        .photo-container {
          position: relative;
          width: 100%;
          min-height: 1px;
        }


        .photo-container.resize {
          /*background-color: #ddd;*/
          background: repeating-linear-gradient(
            45deg,
            #ddd,
            #ddd 10px,
            #d9d9d6 10px,
            #d9d9d6 20px
          );
          border: 1px dashed #666;
        }

        .top-right {
            top: 10px;
            right: 10px;
        }

    </style>
@endpush

@section('body-class', 'bg-light')

@section('content')

<div id="result">
    @if (Session::has('status'))
        <div class="alert alert-success  offset4 span4"><button type="button" class="close">×</button>{{ Session::get('status') }}</div>
    @endif
</div>


<div class="header text-center">
    <h1>{{ $topic->name }}</h1>
</div>

<div class="position-fixed top-right p-2">
    <a href="#" onclick="event.preventDefault(); save();">Save</a>
</div>

<div id="items">
    @foreach ($topic->items as $i=>$item)
        <div class="photo-container {{ ($i==0) ? 'resize' : '' }}" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >
            <div
                class="photo {{ ($i==0) ? 'drag-and-resize' : '' }}"
                data-id="{{$item->id}}"
                data-orig-x="{{$item->pivot->pos_x}}"
                data-orig-y="{{$item->pivot->pos_y}}"
                data-x="{{$item->pivot->pos_x}}"
                data-y="{{$item->pivot->pos_y}}"
                data-orig-width="{{$item->pivot->width}}"
                data-orig-height="{{$item->pivot->height}}"
                style="left: {{$item->pivot->pos_x}}px; top: {{$item->pivot->pos_y}}px; width: {{$item->pivot->width}}px; height: {{$item->pivot->height}}px;" >
                @if (true)
                    @include($item->getComponent(), ['item' => $item])
                @else
                    <a href="{{ asset($item->file) }}" class="image-link" title="{{$item->name}}" data-author="{{$item->author}}">
                        <img src="{{ asset($item->file) }}" />
                    </a>
                @endif
            </div>
        </div>
    @endforeach
</div>

@stop


@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="{{ asset('/js/edit.js') }}"></script>

@endpush