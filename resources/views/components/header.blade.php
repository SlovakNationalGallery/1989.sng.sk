<div class="container casopis-header mb-0 mb-sm-2 mb-md-3 mb-xl-4 pb-4 pt-4 pt-lg-5">
    <div class="row">
        <div class="offset-md-1 offset-lg-2 offset-xl-3 col-md-11 col-lg-9 col-xl-7 pr-4">
            <div class="header pt-5 file-paper bg-v1 ml-1 mr-0 px-0 px-sm-3 pl-xl-5 text-center">
                <h1 class="p-0 py-sm-4">ČAS-OPIS <span>1989</span></h1>
            </div>
        </div>
    </div>
    <div class="row mt-5 mt-sm-0">
        <div class="offset-sm-1 offset-md-3 offset-lg-4 offset-xl-5 col-sm-10 col-md-8 col-lg-7 col-xl-5 pr-4 pr-sm-5">
            <div class="perex mr-1">
                <div class="bg"></div>
                <div class="content p-4">
                    <h5 class="mb-0">
                        Deň po dni sledujeme vývoj Nežnej revolúcie v&nbsp;<a class="text-dark" href="#dennik" id="scroll-to-journal"><strong>denníku Júliusa Kollera</strong></a>.
                        Prostredníctvom fotografií, plagátov, rozhovorov a&nbsp;videí spoznávame na&nbsp;<a class="text-dark" href="#temy" id="scroll-to-topics"><strong>tematických nástenkách</strong></a>
                        kreativitu občanov, ich&nbsp;požiadavky, názory a&nbsp;nádeje.
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script defer>
$("#scroll-to-journal").click(function(event) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#dennik").offset().top,
    }, 600);
});
$("#scroll-to-topics").click(function(event) {
    $([document.documentElement, document.body]).animate({
        scrollTop: $("#temy").offset().top - 70,
    }, 600);
});
</script>
@endpush
