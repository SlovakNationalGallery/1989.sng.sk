@extends('layouts.topic')

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >
            <div
                class="item"
                data-orig-x="{{$item->pivot->pos_x}}"
                data-orig-y="{{$item->pivot->pos_y}}"
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

    <script>
        $(window).on("resize", function () {
            repositionItems();
        }).resize();
    </script>

@endpush
