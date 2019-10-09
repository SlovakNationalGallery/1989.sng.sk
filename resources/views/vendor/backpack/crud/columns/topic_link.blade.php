<!-- topic_link -->
@php
    $topic = $entry->{$column['entity']};
@endphp

<span>
    @if ($topic)
        <a href="{{ url($crud->getRoute(), $topic->id) }}">{{ $topic->name }}</a>
    @else
        &ndash;
    @endif
</span>
