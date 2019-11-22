@php
$topic = App\Models\Topic::where('id', $item->source)->first();
@endphp

<div class="item-topic" style="background-image: url('/{{$topic->cover_image}}');">
    <div class="item-topic-description text-light px-sm-3 px-md-5 py-4">
        <h2 class='text-light pt-0'>{{ $topic->name}}</h2>
        {{ isset($item->text) ? $item->text : substr($topic->description, 0, 400).'…'}}
        <div>
            <a class="mt-4 px-5 btn btn-outline-blue" href="/{{$topic->slug}}" target="_blank">Zisti viac</a>
        </div>
    </div>
</div>