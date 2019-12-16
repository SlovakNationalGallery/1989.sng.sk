<div class="container casopis-header">
    <div class="header file-paper bg-v1 shift-block">
        <h1 class="p-0 p-md-2 p-lg-4">ČAS-OPIS <span>1989</span></h1>
    </div>
    <div class="perex shift-block with-bg">
        <div class="bg"></div>
        <div class="content p-4">
            <h5 class="mb-0">
                Deň po dni sledujeme vývoj Nežnej revolúcie <a class="text-dark" href="#dennik" id="scroll-to-journal"><strong>v&nbsp;denníku Júliusa Kollera</strong></a>.
                Prostredníctvom fotografií, plagátov, rozhovorov a&nbsp;videí spoznávame na&nbsp;<a class="text-dark" href="#temy" id="scroll-to-topics"><strong>tematických nástenkách</strong></a>
                kreativitu občanov, ich&nbsp;požiadavky, názory a&nbsp;nádeje.
            </h5>
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
