@extends('layouts.master')

@push('styles')
@endpush

@section('content')
    <router-view></router-view>
@stop

@push('scripts')
<script defer>
    new Vue({ router: Router, el: '#app' })
</script>
@endpush
