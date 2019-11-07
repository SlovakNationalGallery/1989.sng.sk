@extends('layouts.topic')

@section('items')
    @foreach ($topic->items as $i=>$item)
        <div class="item-container" style="height: {{$item->pivot->container}}px" data-orig-height="{{$item->pivot->container}}" >
            <div
                class="item"
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

@endpush
