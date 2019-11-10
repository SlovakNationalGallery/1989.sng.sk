<footer class="w-100">
    <div class="footer container">
        <div class="row">
            <div class="col-sm-12 topics">
                @foreach (App\Models\Topic::$available_categories as $catKey => $cat)
                @if (isset($topics[$catKey]))
                <dl>
                    <dt>{{ $cat }}</dt>
                    @foreach ($topics[$catKey] as $topic)
                    @if ($topic->is_active)
                    <dd class="active"><a href="/{{ $topic->slug }}">{{ $topic->name }}</a></dd>
                    @else
                    <dd class="inactive">{{ $topic->name }}</dd>
                    @endif
                    @endforeach
                </dl>
                @endif
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 new-topics">
                <h3>
                    Nové témy <br />pribudnú čoskoro
                </h3>
            </div>
        </div>

    </div>

    <div class="text-center">
        <a href="#top" title="Na začiatok stránky" class="jump-to-top btn btn-dark"><img
                src="{{ asset('images/caret-up-white.svg') }}" alt="šípka hore" /></a>
    </div>


    <div class="footer credits">

        <div class="container">

            <div class="row d-flex align-items-center">
                <div class="col-sm-3 ">
                    <a class="btn btn-dark" href="o-projekte">O projekte</a>
                </div>
                <div class="col-sm-3 ">
                    <a href="http://www.sng.sk" title="Slovenská národná galéria">
                        <img src="{{asset('images/SNG_logo_with_title.svg')}}" />

                </div>
                <div class="col-sm-3 ">

                    <a href="https://spolocnost.o2.sk/ferova-nadacia" title="O2: Sloboda nie je samozrejmosť">
                        <img src="{{asset('images/sloboda_o2.svg')}}" />
                    </a>

                </div>
                <div class="col-sm-3 ">
                    Vyrobil: <a href="http://www.lab.sng.sk">lab.SNG</a>

                </div>
            </div>
        </div>
    </div>
</footer>