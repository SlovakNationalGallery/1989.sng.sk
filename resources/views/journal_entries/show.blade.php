@extends('layouts.master')

@push('styles')
@endpush

@section('content')
    <h2>{{ $entry->written_at }}</h2>
    <div style="display: flex">
        @foreach($entry->transcriptionPages as $transcriptionPage)
            <img src="https://fromthepage.com/image-service/{{$transcriptionPage->id}}/full/full/0/default.jpg" width="300" />
        @endforeach
    </div>
    <div>
        {!! $entry->content_formatted !!}
    </div>
@stop
