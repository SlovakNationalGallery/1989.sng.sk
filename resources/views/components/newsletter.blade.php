@push('styles')
<style>
    .newsletter {
        transform: translateX(-2%);
        max-width: 48vw;
        margin: 4rem auto 6em auto;
    }

    .newsletter .cnt {
        background: white;
    }

    .newsletter .bg {
        background-image: url("{{asset('/images/intro/06-For-schools-01.png')}}");
        transform: translate(0.5rem, -0.5rem);
    }

    #subscribe_form .row > div{
        padding: .5rem;
    }
    #subscribe_form .row > div:last-child{
        text-align: right;
    }

</style>
@endpush


<div class="newsletter doubled-bg shift-block paper-border">
    <div class="bg">&nbsp;</div>
    <div class="block-paper">
        <form id="subscribe_form" class="container-fluid">
            <h3>Prihláste sa na newsletter</h3>
            <div class="row">
                <div class="col-md-6 col-lg-7 col-sm-12">
                    <input type="email" name="user_email" id="user_email" class="form-control">
                </div>
                <div class="col-md-6 col-lg-5 offset-md-0 col-sm-8 offset-sm-4">
                    {{ csrf_field() }}
                    <button id="submit" type="submit" class="btn btn-info">Chcem byť v obraze</button>
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
