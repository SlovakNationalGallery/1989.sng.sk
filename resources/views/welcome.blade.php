@extends('layouts.master')
@push('styles')

<style>
    body {
        background-image: url("{{asset('/images/intro/BG-0' . random_int(2, 4) . '.jpg') }}");
        background-attachment: fixed;
        background-size: cover;
        text-align: center;
        background-position: top center;
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
        position: relative;
        z-index: 10;
        padding: 1rem;
    }

    .header {
        transform: translate(2em);
        width: 40vw;
        max-width: 40rem;
        margin: auto;
        padding: 2.5em 1em;
    }

    .header * {
        text-align: center;
    }

    .header::after {
        background-image: url("{{asset('/images/intro/01-Cover-01.png')}}");
        background-position: center;
    }

    .header .cnt {
        margin-bottom: 1rem;
        padding: 2rem 1rem;
    }

    .subheader {
        transform: translate(33%, -3em);
        position: relative;
        margin: auto;
        max-width: 40vw;
        min-width: 250px;
        background: #D43C3D;
        z-index: 10;
        font-weight: bold;
        font-size: 1.5em;
        top: 3em;
    }

    .subheader .cnt {
        margin-bottom: 1rem;
        padding: 2rem 1rem;
        transform: translate(-0.5rem, -0.5rem);
        background-image: url("{{asset('/images/intro/02-Perex-01.png')}}");
        background-size: cover;
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
        max-width: 38vw;
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
        max-width: 80vw;
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

    button#submit{
        background: #637fcf !important;
    }

    @media (max-width:600px) {
        .shift-block {
            transform: none !important;
            max-width: 90vw !important;
            margin: 1em auto;
        }

        .header {
            width: 90vw;
        }


        .with-bg,
        .with-bg .bg {
            min-width: 60vw !important;
        }

        .shift-block .cnt,
        .with-bg {
            max-width: 90vw;
        }
    }

</style>
@endpush

@section('content')
<div id="overlay">
    <div class="container-fluid py-4 h-100 px-lg-4 px-xxl-5">
        <div class="header file-paper bg-v1 shift-block">
            <h1>ČAS-OPIS <span>1989</span></h1>
        </div>
        <div class="subheader shift-block with-bg">
            <div class="bg"></div>
            <div class="cnt">
                <strong>Ako sa tvorili a šírili kľúčové myšlienky Novembra 1989?</strong> <br />Deň po dni sledujeme vývoj Nežnej
                revolúcie v denníku Júliusa Kollera a prostredníctvom fotografií, plagátov, rozhovorov a&nbsp;videí spoznávame
                kreativitu občanov, ich požiadavky, názory a nádeje.
            </div>
        </div>
        <div class="deadline shift-block with-bg">
            <div class="bg"></div>
            <div class="cnt">
                <h3>Spúšťame 11. novembra 2019</h3>
            </div>
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
        <div class="block-paper">
            <form id="subscribe_form" class="container-fluid">
                <h3>Prihláste sa na newsletter</h3>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <input type="email" name="user_email" id="user_email" class="form-control">
                    </div>
                    <div class="col-md-6 offset-md-0 col-sm-8 offset-sm-5">
                        {{ csrf_field() }}
                        <button id="submit" type="submit" class="btn btn-dark">Chcem byť v obraze</button>
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
            Čoskoro zverejníme prvý zo série článkov pre študentov, ktoré na príklade tém Novembra 89 priblížia
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
