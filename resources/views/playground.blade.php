@extends('layouts.master')
@push('styles')

<style>
    @import '../css/app.css';

    html {
        font-size: 10pt;
    }

    .col-md-2 {
        border: white solid 1px;
    }

    div[class*="bg-"]::after {
        background-image: url("{{asset('/images/intro/01-Cover-01.png')}}");
    }

    #paper-containers {
        background: #666;
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
            <div class="col-md-2">
                <div class="file-paper">
                    <h4>file-paper</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v0">
                    <h4>file-paper</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v1">
                    <h4>file-paper bg-v1</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v2">
                    <h4>file-paper bg-v2</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v3">
                    <h4>file-paper bg-v3</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v4">
                    <h4>file-paper bg-v4</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="block-paper ">
                    <h4>block-paper </h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper  bg-v0">
                    <h4>block-paper </h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v1">
                    <h4>block-paper bg-v1</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v2">
                    <h4>block-paper bg-v2</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v3">
                    <h4>block-paper bg-v3</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v4">
                    <h4>block-paper bg-v4</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="tableau-paper ">
                    <h4>tableau-paper </h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper  bg-v0">
                    <h4>tableau-paper </h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v1">
                    <h4>tableau-paper bg-v1</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v2">
                    <h4>tableau-paper bg-v2</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v3">
                    <h4>tableau-paper bg-v3</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v4">
                    <h4>tableau-paper bg-v4</h4>
                    V októbri zverejníme prvý zo série článkov pre študentov
                </div>
            </div>
        </div>
    </div>
</div>
@stop