@extends('layouts.topic')

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >

            @if ($item->file)
                <a href="{{ asset($item->file) }}" class="image-link" title="{{ $item->full_name }}" data-source="{{ $item->source }}">
            @endif

            <div
                class="item"
                data-orig-x="{{$item->pivot->pos_x}}"
                data-orig-y="{{$item->pivot->pos_y}}"
                data-orig-width="{{$item->pivot->width}}"
                data-orig-height="{{$item->pivot->height}}"
                style="left: {{$item->pivot->pos_x}}px; top: {{$item->pivot->pos_y}}px; width: {{$item->pivot->width}}px; height: {{$item->pivot->height}}px;" >
                    @include($item->getComponent(), ['item' => $item])
            </div>

            @if ($item->file)
                </a>
            @endif
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
              mainClass: 'mfp-with-zoom',

              zoom: {
                enabled: true,

                duration: 300,
                easing: 'ease-in-out',

                opener: function(openerElement) {
                  return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
              },

              image: {
                verticalFit: true,
                titleSrc: function(item) {
                  var title = '';
                  if (item.el.attr('title')) {
                    title += item.el.attr('title');
                  }
                  if (item.el.attr('data-source')) {
                    title += '<br>' + '&copy; ' + item.el.attr('data-source');
                  }
                  return title;
                }
              }

            });
        });
    </script>

@endpush
