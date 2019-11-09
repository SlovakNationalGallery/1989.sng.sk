{{-- regular object attribute --}}
@php
    $value = data_get($entry, $column['name']);

    if( !empty($value) ) {

        // if attribute casting is used, convert to object
        if (is_array($value)) {
            $video = (object)$value;
        } elseif (is_string($value)) {
            $video = json_decode($value);
        } else {
            $video = $value;
        }
    }
@endphp
<span>
    @if( isset($video) )
    <iframe src="https://player.vimeo.com/video/{{ $video->id }}?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=159754" width="{{ $video->width }}" height="{{ $video->height }}" frameborder="0" allow="autoplay; fullscreen" allowfullscreen title="{{ $video->title }}"></iframe>
    @else
    -
    @endif
</span>