@extends('layouts.master')
@section('page_title', "$journalEntry->written_at_romanized • Čas-opis 1989")
@section('page_description', Str::limit(strip_tags($journalEntry->content), 300))

@section('content')
<div id="journal-entries" class="container mt-5">
    <div class="row">
        <div class="offset-lg-2 col-lg-8 bg-white p-5">
            <a href="/" class="btn btn-outline-dark btn-sm">← Domov</a>
            <div id="header" class="text-center">
                <h2 class="py-0">Čas-opis</h2>
                <h5 id="subtitle" class="text-muted">Denník Júliusa Kollera</h5>
            </div>
            <router-view></router-view>
        </div>
    </div>
</div>
@stop
