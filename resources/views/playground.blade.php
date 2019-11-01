@extends('layouts.master')
@push('styles')

<style>
    div[class*="bg-"]::after {
        background-image: url("{{asset('/images/intro/01-Cover-01.png')}}");
    }

    div[class*="bg-"] {
        margin: 0.5em;
    }

    #paper-containers {
        background: #666;
        padding: 1rem;
    }

</style>
@endpush

@section('content')
<div id="overlay"></div>

<div class="block-paper">
    <h1>Playground</h1>
</div>

<div id="paper-containers" class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="block-paper">
                <h4>paper containers</h4>
                texture image has to be added as <b>::after</b> pseudoelement
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <div class="file-paper">
                    <h4>file-paper</h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="file-paper bg-v0">
                    <h4>file-paper + bg</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="file-paper bg-v1">
                    <h4>file-paper bg-v1</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="file-paper bg-v2">
                    <h4>file-paper bg-v2</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="file-paper bg-v3">
                    <h4>file-paper bg-v3</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="file-paper bg-v4">
                    <h4>file-paper bg-v4</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="block-paper ">
                    <h4>block-paper </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block-paper bg-v0">
                    <h4>block-paper + bg</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block-paper bg-v1">
                    <h4>block-paper bg-v1</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block-paper bg-v2">
                    <h4>block-paper bg-v2</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block-paper bg-v3">
                    <h4>block-paper bg-v3</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="block-paper bg-v4">
                    <h4>block-paper bg-v4</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="tableau-paper ">
                    <h4>tableau-paper </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tableau-paper bg-v0">
                    <h4>tableau-paper + bg</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tableau-paper bg-v1">
                    <h4>tableau-paper bg-v1</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tableau-paper bg-v2">
                    <h4>tableau-paper bg-v2</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tableau-paper bg-v3">
                    <h4>tableau-paper bg-v3</h4>
                </div>
            </div>
            <div class="col-md-3">
                <div class="tableau-paper bg-v4">
                    <h4>tableau-paper bg-v4</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@stop