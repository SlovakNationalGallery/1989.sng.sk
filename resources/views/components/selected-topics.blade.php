@push('styles')
<style>
    .selected-topics {
        margin-top: 1rem;
    }

    .selected-topic {
        padding: 2em !important;
    }

    .selected-topics h3 {
        text-align: center;
        color: white;
        padding-left: 0;
    }

    .selected-topics h3 span {
        font-weight: normal;
    }

    .selected-topics h3 .date {
        display: block;
        font-weight: normal;
        font-family: 'AvenirLTPro-Roman';
        padding: .5rem;

    }

    .selected-topic img {
        transform: translate(-.5em, -.5em);
    }

    .selected-topic .description {
        color: white;
    }

</style>
@endpush

<div class="container selected-topics">
    <div class="row">
        <div class="col-sm-12">
            <h3>
                Výber tém pre
                @php
                $dt = \Carbon\Carbon::parse($date);
                @endphp
                <span class='date'>{{$dt -> format('d.') }} <span class="underline">{{$dt -> format('F.') }}</span>
                    {{$dt -> format('Y') }}</span>
            </h3>
        </div>
    </div>
    <div class="row">
        @foreach ($topics as $topic )
        <div class="col-md-4 col-sm-12 selected-topic">
            {{-- na mobile by som sem dal carousel --}}
            <div class="white">
                <a href="/{{$topic-> slug}}">
                    <img class="w-100" src="{{ $topic -> cover_image }}" />
                </a>
            </div>
            <div class="description">
                <a href="/{{$topic-> slug}}">
                    <h3>
                        {{ $topic -> name }}
                    </h3>
                </a>
                <p>
                    {{ substr($topic -> description, 0, 200)}}
                    @if (strlen($topic -> description) > 200))
                    ...
                    @endif
                </p>
                <button class="btn btn-dark"><a href="/{{$topic-> slug}}">Čítaj viac</a></button>
            </div>
        </div>
        @endforeach
    </div>
</div>