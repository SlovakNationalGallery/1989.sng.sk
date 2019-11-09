@extends('layouts.topic')

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >
            <a href="{{ asset($item->file) }}" class="image-link" title="{{ $item->name }}" data-author="{{ $item->author }}">
            <div
                class="item"
                data-orig-x="{{$item->pivot->pos_x}}"
                data-orig-y="{{$item->pivot->pos_y}}"
                data-orig-width="{{$item->pivot->width}}"
                data-orig-height="{{$item->pivot->height}}"
                style="left: {{$item->pivot->pos_x}}px; top: {{$item->pivot->pos_y}}px; width: {{$item->pivot->width}}px; height: {{$item->pivot->height}}px;" >
                @if ($item->file)

                        @include($item->getComponent(), ['item' => $item])

                @else
                    @include($item->getComponent(), ['item' => $item])
                @endif
            </div>
            </a>
        </div>
    @endforeach
@endsection

@push('scripts')

    <script>
        $(window).on("resize", function () {
            repositionItems();
        }).resize();

        $( document ).ready(function() {
            $('.image-link').magnificPopup({
              type: 'image',
              mainClass: 'mfp-with-zoom', // this class is for CSS animation below

              zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                opener: function(openerElement) {
                  return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
              },

              image: {
                verticalFit: true,
                titleSrc: function(item) {
                  var title = '';
                  if (item.el.attr('title')) {
                    title += item.el.attr('title') + '<br>';
                  }
                  return title + '&copy; ' + item.el.attr('data-author');
                }
              }

            });
        });
    </script>

@endpush
