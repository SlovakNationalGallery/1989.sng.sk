@extends('layouts.master')
@push('styles')

<style>
    @import '../css/app.css';

    body {
        background-image: url("{{asset('/images/intro/BG-0' . random_int(2, 4) . '.jpg') }}");
        background-attachment: fixed;
        background-size: cover;
        text-align: center;
        background-position: top center;
        padding-top: 10vh;
    }

    .container {
        text-align: center;
    }

    .with-bg {
        background-color: white;
        margin: auto;
        max-width: 40vw;
        min-width: 400px;
        margin: 3rem auto;
        text-align: left;
        padding: 0;
        position: relative;
    }

    .with-bg>* {
        background-size: cover;
        background-position: center center;
    }

    .bg {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 0;
    }

    .cnt {
        max-width: 40vw;
        min-width: 400px;
        position: relative;
        z-index: 10;
        padding: 1rem;
    }

    .header {
        transform: translate(2em);
    }

    .header * {
        text-align: center;
    }

    .header .with-bg:first-child {
        background-color: transparent;
    }

    .header .with-bg:first-child .bg {
        background-color: white;
        max-width: calc(100% - 4rem);
    }

    .header .with-bg:first-child .bg::before {
        content: "";
        background-image: url("{{asset('/images/intro/border-02.svg')}}");
        background-repeat: repeat-y;
        background-size: 4rem auto;
        position: absolute;
        left: -3.9rem;
        height: 100%;
        top: 0;
        width: 4rem;
    }

    .header .with-bg:first-child div:not(.bg) {
        margin-left: -4rem;
    }

    .header .cnt {
        margin-bottom: 1rem;
        padding: 2rem 1rem;
        transform: translate(0.5rem, 0.5rem);
        background-image: url("{{asset('/images/intro/01-Cover-01.png')}}");
        background-size: cover;
    }

    .header span {
        font-family: 'AvenirLTPro-Roman';
    }

    .subheader {
        transform: translate(50%, -3em);
        position: relative;
        margin: auto;
        max-width: 20vw;
        min-width: 250px;
        background: #D43C3D;
        font-family: 'AvenirLTPro-Black';
        z-index: 10;
    }

    .subheader .cnt {
        margin-bottom: 1rem;
        padding: 2rem 1rem;
        max-width: 20vw;
        min-width: 250px;
        transform: translate(-0.5rem, -0.5rem);
        background-image: url("{{asset('/images/intro/02-Perex-01.png')}}");

    }

    .deadline {
        max-width: 30vw;
        margin-bottom: 10rem;
    }

    .deadline .cnt {
        background: white;
        text-align: center;
    }

    .deadline .bg {
        transform: translate(0.5rem, 0.5rem);
        background-image: url("{{asset('/images/intro/04-Real-time-01.png')}}");
        margin: 0;
    }

    .intro .bg {
        background-color: #637fcf;
    }

    .intro .cnt {
        background-image: url("{{asset('/images/intro/04-Real-time-01.png')}}");
        transform: translate(-0.5rem, 0.5rem);
        padding: 1em;
        margin: 0;
        color: white;
        text-align: left;
    }

    .intro h3 {
        text-align: left;
        padding: 0
    }

    .newsletter {
        align-content: center;
        transform: translateX(5%);
        margin: auto;
        max-width: 34vw;
    }

    .newsletter2 {
        transform: translateX(-2%);
        max-width: 34vw;
        margin: 0 auto 6em auto;
    }

    .newsletter2 .cnt {
        background: white;
    }

    .newsletter2 .bg {
        background-image: url("{{asset('/images/intro/06-For-schools-01.png')}}");
        transform: translate(0.5rem, -0.5rem);
    }


    .for-schools .bg {
        background-image: url("{{asset('/images/intro/06-For-schools-01.png')}}");
        transform: translate(0.5rem, 0.5rem);
        padding: 1em;
    }

    .footer {
        background: #666;
        color: white;
        margin: auto;
        width: 30em;
        padding: 1rem;
    }

    .icons {
        width: 140px;
        margin: auto;
        text-align: center;
        font-size: .8em;

    }

    .icons img {
        width: 2.0rem;
        margin: .8rem auto;
        display: inline-block;
    }

    .paper-border {
        position: relative;
    }

    .paper-border>div:not(.border) {
        margin-left: -1.2rem;
    }

    .paper-border>.border::before {
        content: "";
        background-image: url("{{asset('/images/intro/border-01.svg')}}");
        background-repeat: repeat-y;
        background-size: 1.25rem auto;
        position: absolute;
        left: -1.2rem;
        height: 100%;
        top: 0;
        width: 3rem;
    }

    @media (max-width:600px) {
        .shift-block {
            transform: none !important;
        }

        .shift-block .cnt {
            max-width: 90vw;
        }
    }

</style>
@endpush

@section('content')
<div class="header shift-block">
    <div class="with-bg">
        <div class="bg"></div>
        <div class="cnt">
            <h1>ČAS-OPIS <span>1989</span></h1>
        </div>
    </div>
    <div class="subheader shift-block with-bg">
        <div class="bg"></div>
        <div class="cnt">
            Vizuálna kultúra, idey a udalosti Nežnej revolúcie, prebudenie občianskej spoločnosti a šírenie jej
            posolstiev.
        </div>
    </div>
</div>
<div class="deadline shift-block with-bg">
    <div class="bg"></div>
    <div class="cnt">
        <h3>Spúšťame 11. novembra 2019</h3>
    </div>
</div>


<div class="newsletter shift-block">
    <div class="intro with-bg">
        <div class="bg">&nbsp;</div>
        <div class="cnt container-fluid row">
            <div class="col-md-3"><img src="{{asset('images/intro/calendar-icon.svg')}}" /></div>
            <div class="col-md-9">
                <h3>Sledujte udalosti v&nbsp;reálnom čase</h3>
                Prihláste sa na odber pravidelného súhrnu udalostí prelomového obdobia, spolu s&nbsp;výberom
                tém.
            </div>
        </div>
    </div>
</div>


<div class="newsletter2 with-bg shift-block paper-border">
    <div class="bg">&nbsp;</div>
    <div class="cnt border container-fluid">
        <form id="subscribe_form">
            <h3>Prihláste sa na newsletter</h3>
            <div class=" row">
                <div class="col-md-7">
                    <input type="email" name="user_email" id="user_email" class="form-control">
                </div>
                <div class="col-md-5">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-primary">Chcem byť v obraze</button>
                </div>
            </div>
        </form>
        <div id="subscribe_form_done" class="row" style="display: none;">
            <h3>Vďaka!</h3>
        </div>
        <div id="subscribe_form_error" class="row" style="display: none;">
            <div class="col-sm-12">
                Auč:( Niekde asi máme chybu, skúste to prosím neskôr.
            </div>
        </div>
    </div>
</div>

<div class="for-schools shift-block with-bg">
    <div class="bg">&nbsp;</div>
    <div class="cnt">
        <h3>Pre školy</h3>
        V októbri zverejníme prvý zo série článkov pre študentov, ktoré na príklade tém Novembra 89 priblížia
        princípy, vznik a šírenie konšpiračných teórií.
    </div>
</div>

<div class="footer">
    <div class="icons row">
        <a class="col-sm-12" href="http://www.sng.sk" title="Slovenská národná galéria"><img
                src="{{asset('images/intro/sng_web.svg')}}" /><br />SNG</a>
    </div>
    <div>Vyrobil: <a href="http://www.lab.sng.sk">lab.SNG</a></div>
</div>
@stop


@push('scripts')
<script defer>
    $('#user_email').on('input', function() {
	var input=$(this);
	var re = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var is_email=re.test(input.val());
	if(is_email){input.removeClass("invalid").addClass("valid");}
	else{input.removeClass("valid").addClass("invalid");}
});


$("#subscribe_form").submit(function($frm){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.post('../api/subscribe', {'user_email': $("#user_email").val()}, function(e){
        if (e.res || e.subscribed){
            $("#subscribe_form").slideUp();
            $("#subscribe_form_done").slideDown();
        }
    }).fail(function(e){
        $("#subscribe_form").slideUp();
        $("#subscribe_form_error").slideDown();
        return false;
    });

    return false;
})

</script>
@endpush