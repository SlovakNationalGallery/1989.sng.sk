@extends('layouts.topic')

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container item-type-{{ $item->type }}" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >

            @if ($item->file && $item->type != 'slogan')
                <a href="{{ asset($item->file) }}" class="image-link" title="{{ $item->full_name }}" data-text="{{ $item->text }}">
            @elseif ($item->video)
                <a href="{{ $item->video->url }}" class="vimeo-link" title="{{ $item->full_name }}" data-text="{{ $item->text }}">
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

            @if ($item->file || $item->video)
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
                  var title = '<div class="mt-1">';
                  if (item.el.attr('title')) {
                    title += item.el.attr('title');
                  }
                  if (item.el.attr('data-text')) {
                    title += '<br>' + item.el.attr('data-text');
                  }
                  title += '</div>';
                  return title;
                }
              },

              callbacks: {
                  resize: function() {
                      var img = this.content.find('img');
                      img.css('max-height', parseFloat(img.css('max-height')) * 0.95);
                  }
              }

            });

            $('.vimeo-link').magnificPopup({
                    type: 'iframe',
                    mainClass: 'mfp-fade',
                    removalDelay: 160,
                    preloader: false,
                    fixedContentPos: false
            });
        });

        $(document).click(function(event) {

            $('.item-container').removeClass('focused');
            const targets = '.item-author-text, .item-text, .item-quotation';
            if ($(event.target).is(targets) || ($(event.target).parents(targets).length > 0)) {
                $(event.target).parents('.item-container').addClass('focused');
            }
        });
    </script>

@endpush
