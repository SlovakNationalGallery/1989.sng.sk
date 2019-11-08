<div class="item-image">
    <div class="item-image-background">
        <div class="item-image-container">
            <img src="{{ asset($item->file) }}" alt="{{ $item->full_name }}" />
        </div>
        <div class="item-image-description">{{ $item->full_name }}</div>
    </div>
</div>
