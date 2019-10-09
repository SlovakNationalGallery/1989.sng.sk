<!-- topic_link -->
@php
    $topic = $entry->{$field['entity']};
@endphp

<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    <br>

    @if ($topic)
        <a href="{{ url($crud->getRoute(), [$topic->id, 'edit']) }}">{{ $topic->name }}</a>
    @else
        &ndash;
    @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>
