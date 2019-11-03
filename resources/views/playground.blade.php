@extends('layouts.master')
@push('styles')

<style>
    html {
        font-size: 9pt;
    }

    div[class*="bg-"]>.bg {
        background-image: url("{{asset('/images/intro/01-Cover-01.png')}}");
    }

    div[class*="col-"] {
        padding: 0.5em;
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
                <div class="bg"> </div>
                texture image has to be added as <b>::after</b> pseudoelement
            </div>
        </div>
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-2">
                <div class="file-paper">
                    <h4>file-paper</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v0">
                    <h4>file-paper + bg</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v1">
                    <h4>file-paper bg-v1</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v2">
                    <h4>file-paper bg-v2</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v3">
                    <h4>file-paper bg-v3</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="file-paper bg-v4">
                    <h4>file-paper bg-v4</h4>
                    <div class="bg"> </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="block-paper ">
                    <h4>block-paper </h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v0">
                    <h4>block-paper + bg</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v1">
                    <h4>block-paper bg-v1</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v2">
                    <h4>block-paper bg-v2</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v3">
                    <h4>block-paper bg-v3</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="block-paper bg-v4">
                    <h4>block-paper bg-v4</h4>
                    <div class="bg"> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="tableau-paper ">
                    <h4>tableau-paper </h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v0">
                    <h4>tableau-paper + bg</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v1">
                    <h4>tableau-paper bg-v1</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v2">
                    <h4>tableau-paper bg-v2</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v3">
                    <h4>tableau-paper bg-v3</h4>
                    <div class="bg"> </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="tableau-paper bg-v4">
                    <h4>tableau-paper bg-v4</h4>
                    <div class="bg"> </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="block-paper">
            <div class="ruled">
                <h1>.ruled h1</h1>
                Polskí komunisti sa snažia vyzískať politický kapitál proti Mazowieckému a „Solidarite“ z prípadu
                návštevy Kohla v Anna-Bergu – komunisti využívajú polské nacionalistické čaty (ktoré sú veľmi
                expresívne) proti „Solidarite“ –
                <h2>.ruled h2</h2>
                obviňujú ju že za obchodné (ekonomické) ciele sú ochotný predať národné posvätné hodnoty –
                NSR tlač rozoberá netaktický program Kohlovej návštevy v Polsku –Včera večer ďašie masové manifestácie v
                NDR mestách za reformy v politike – (za legalizáciu opozičných hnutí)

                <h3>.ruled h3</h3>
                Ochranu a kontrolu štátnej hranice mala na starosti ozbrojená zložka pohraničná stráž, ktorá mala
                zabrániť “narušiteľom” prekročiť hranicu za každú cenu, a to aj streľbou. Ak sa podarilo “narušiteľa”
                zabiť na druhej strane hranice, Pohraničná stráž mala pokyn ...

                <h4>.ruled h4</h4>
                <div class="bg"> </div>
                Pri strážení hranice sa využívala aj pomoc civilistov, ktorí spĺňali množstvo kritérií - patrili
                k Pomocníkom pohraničnej stráže (PPS). Ich úlohou bolo sledovať a udávať ľudí podozrivých z
                prípravy na prekročenie hranice. Za takúto pomoc boli aj finančne odmeňovaní. ...
            </div>
        </div>
    </div>
</div>

@include('components.letters_expositions')
@include('components.footer', ['topics' => App\Models\Topic::orderBy('name', 'asc')->get()->groupBy('category')]);
@stop