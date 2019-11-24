@extends('layouts.master')
@section('page_title', "$journalEntry->written_at_romanized • Denník Júliusa Kollera • Čas-opis 1989")
@section('page_description', Str::limit(strip_tags($journalEntry->content), 300))

@section('content')
<div id="journal-entries" class="container">
    <div class="row">
        <div class="offset-lg-2 col-lg-8 bg-white pt-3 pt-md-5 px-md-5">
            <a href="/" class="btn btn-outline-dark btn-sm">← Domov</a>
            <div id="header" class="text-center mt-4 mt-md-0">
                <h2 class="py-0">Čas-opis</h2>
                <h5 id="subtitle" class="text-muted">Denník Júliusa Kollera</h5>
            </div>
            <router-view></router-view>
        </div>
    </div>
</div>
@stop
