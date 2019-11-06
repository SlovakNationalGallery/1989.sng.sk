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

    .doubled-bg {
        margin: auto;
        max-width: 40vw;
        min-width: 400px;
        margin: 3rem auto;
        text-align: left;
        padding: 0;
        position: relative;
    }

    .doubled-bg>* {
        background-size: cover;
        background-position: center center;
    }


    .cnt {
        position: relative;
        z-index: 10;
        padding: 1rem;
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

    .for-schools::before {
        background: white;
    }

    .for-schools::after {
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

    button#submit {
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


        .doubled-bg,
        .doubled-bg .bg {
            min-width: 60vw !important;
        }

        .shift-block .cnt,
        .doubled-bg {
            max-width: 90vw;
        }
    }

</style>
@endpush

@section('content')
@include('components.header')
<div class="deadline shift-block doubled-bg">
    <div class="bg"></div>
    <div class="cnt">
        <h3>Spúšťame 11. novembra 2019</h3>
    </div>
</div>


<div class="newsletter shift-block">
    <div class="intro doubled-bg">
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


<div class="newsletter2 doubled-bg shift-block paper-border">
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

<div class="for-schools shift-block doubled-bg">
    <h3>Pre školy</h3>
    Čoskoro zverejníme prvý zo série článkov pre študentov, ktoré na príklade tém Novembra 89 priblížia
    princípy, vznik a šírenie konšpiračných teórií.

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