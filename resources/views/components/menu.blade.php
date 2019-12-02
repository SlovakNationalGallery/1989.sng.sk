@php
$topics = App\Models\Topic::listing()
@endphp

<div id="menu-button" class="menu-icon">
    <span class="menu-icon__line menu-icon__line-left"></span>
    <span class="menu-icon__line"></span>
    <span class="menu-icon__line menu-icon__line-right"></span>
</div>

<div id="menu" class="nav">
    <div class="nav__content text-left pl-3 pl-lg-5">
        <div class="nav__list-item">
            <a href="/" class="text-decoration-none" title="Prejsť na úvodnú stránku">
                <h3 id="top-nav">ČAS-OPIS <span class="year">1989</span></h3>
            </a>
        </div>
        <div class="nav__list-item">
            <a href="/" class="text-decoration-none">
                <h4 id="top-nav">Kalendár</h4>
            </a>
        </div>
        <div class="nav__list-item">
            <a href="/vzdelavacie-aktivity-k-novembru-1989" class="text-decoration-none">
                <h4 id="top-nav">Vzdelávacie aktivity</h4>
            </a>
        </div>
        <div class="nav__list-item">
            <a href="/podujatia-vystavy" class="text-decoration-none">
                <h4 id="top-nav">Podujatia a výstavy</h4>
            </a>
        </div>
        <div class="nav__list-item py-3 topics">
            @foreach (App\Models\Topic::$available_categories as $catKey => $cat)
            @if (isset($topics[$catKey]))
            <dl class="">
                <dt>{{ $cat }}</dt>
                @foreach ($topics[$catKey] as $topic)
                @if($topic->is_visible)
                @if ($topic->is_active)
                <dd class="active">
                    <a href="/{{ $topic->slug }}">{{ $topic->name }}</a>
                    @if ($topic->is_recent)
                    <span class="badge badge-light">nové</span>
                    @endif
                </dd>
                @else
                <dd class="inactive">{{ $topic->name }}</dd>
                @endif
                @endif
                @endforeach
            </dl>
            @endif
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#menu-button').click(()=> {
        $('body').toggleClass('nav-active');
    })
</script>

@endpush