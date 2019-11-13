<div class="item-video">
    <div class="item-image-background">
        <div class="item-image-container">
            <div class="play-icon"></div>
            <img src="{{ asset($item->preview) }}" alt="{{ $item->full_name }}" />
        </div>
        <div class="item-image-description">{{ $item->full_name }}</div>
    </div>
</div>
