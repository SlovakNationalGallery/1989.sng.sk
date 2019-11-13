<div class="item-slogan">
    @if ($item->file)
    <img src="{{ asset($item->file) }}" alt="{{ $item->full_name }}" class="w-100" />
    @endif

    @if ($item->text)
    <h1>{{$item->text}}</h1>
    @endif
</div>