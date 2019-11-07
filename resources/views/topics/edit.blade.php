@extends('layouts.topic')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" />

    <style>
        .drag-and-resize {
          box-sizing: border-box;
          z-index: 50;
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

        .item-container {
          position: relative;
          width: 100%;
          min-height: 1px;
        }


        .item-container.resize {
          background: repeating-linear-gradient(
            45deg,
            #f8f9fa,
            #f8f9fa 10px,
            #f0f0f0 10px,
            #f0f0f0 20px
          );
          border: 1px dashed #aaa;
        }

        .top-right {
            top: 15px;
            right: 15px;
            z-index: 10;
        }

    </style>
@endpush

@section('before-items')
    <div id="result">
        @if (Session::has('status'))
            <div class="alert alert-success  offset4 span4"><button type="button" class="close">×</button>{{ Session::get('status') }}</div>
        @endif
    </div>


    <div class="position-fixed top-right p-2">
        <a href="#" onclick="event.preventDefault(); save();" class="btn btn-secondary" id="save">Save</a>
    </div>
@endsection

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >
            <div
                class="item {{ ($item->file) ? 'preserve-aspect-ratio' : '' }}"
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
@endsection

@push('scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="{{ asset('/js/edit.js') }}"></script>

    <script>
        function repositionItems() {

          var ratio = $( window ).width() / 1280;

          $( '.item-container' ).each(function( index ) {
            var height = $(this).data('orig-height') || 0;
            $(this).css("height", height * ratio);
          });

          $( '.item' ).each(function( index ) {
            var width = $(this).data('orig-width') || 0;
            var height = $(this).data('orig-height') || 0;

            var x = (parseFloat($(this).data('orig-x')) || 0) * ratio;
            var y = (parseFloat($(this).data('orig-y')) || 0) * ratio;

            $(this).css("height", height * ratio);
            $(this).css("width", width * ratio);

            $(this).css("left", x + 'px');
            $(this).css("top", y + 'px');

            $(this).attr('data-x', x)
            $(this).attr('data-y', y)

          });
        }

        $(window).on("resize", function () {
            repositionItems();
        }).resize();
    </script>

@endpush
