@extends('layouts.master')

@section('title', trans('intro.title'))

@push('styles')

<style>
    body {
        background-image: url("{{asset('/images/intro/BG-0' . random_int(2, 4) . '.jpg') }}");
        background-attachment: fixed;
        background-size: cover;
        background-position: top center;
    }

</style>
@endpush

@section('content')

<div id="calendar">
    <calendar :start="daysAvailable.start" :start-at="startAt" :end="daysAvailable.end" :day-callback="dayClbck">
    </calendar>
</div>
<transition-page>
    <router-view></router-view>
</transition-page>
@include('components.letters_expositions')
@include('components.footer', ['topics' => App\Models\Topic::orderBy('name', 'asc')->get()->groupBy('category')]);

)

@stop

@push('scripts')
<script defer>
    new Vue({ router: Router, el: '#app',
        data: {
            daysAvailable: {!!$daysAvailable ?? '{}'!!},
            startAt: '{{ $date }}',
            content: {!!$entries ?? '{}'!!},
        },
        methods: {
            dayClbck: function($day) {
                this.startAt = $day;
                Router.push({ path: `/day/${$day}`});
            }
        },
    })
</script>
@endpush