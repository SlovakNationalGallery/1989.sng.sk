<div class="item-author-text zigzag-paper">
    <div class="media">
        @if($item->author_image)
        <img src="{{ $item->author_image }}" class="align-self-center mr-3 rounded-circle" alt="{{ $item->author }}" width="54" height="54">
        @endif
        <div class="media-body">
            <h5 class="mt-2 mb-0 font-weight-bold author-name">{{ $item->author }}</h5>
            <p class="mb-0 small text-muted">{{ $item->author_role }}</p>
        </div>
    </div>
    <item-text content="{{ parsedown($item->text) }}"></item-text>
</div>
