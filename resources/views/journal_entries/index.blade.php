@extends('layouts.master')

@push('styles')
@endpush

@section('content')
    <h2>Journal entries for tag "{{ $tag->subject }}"</h2>
    <ul>
        @foreach($entries as $entry)
            <li><a href="{{route('journal-entries.show', $entry)}}">{{$entry->written_at}}</a></li>
        @endforeach
    </ul>
@stop
