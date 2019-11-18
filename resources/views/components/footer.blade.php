@php
$topics = App\Models\Topic::listing()
@endphp

<footer class="w-100">
    <div class="footer container">
        <div class="row">
            <div class="col-sm-12 topics">
                @foreach (App\Models\Topic::$available_categories as $catKey => $cat)
                @if (isset($topics[$catKey]))
                <dl>
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
        <div class="row">
            <div class="col-sm-12 new-topics">
                <h3>
                    Nové témy <br />pribudnú čoskoro
                </h3>
            </div>
        </div>

    </div>

    <div class="text-center">
        <a
            href="#top"
            title="Na začiatok stránky"
            class="jump-to-top btn btn-outline-light"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="10"
                viewBox="0 0 16 10"
            >
                <path
                    class="a"
                    d="M14,14.281l-6.993-7.5L0,14.281"
                    style="fill:none;stroke-width:3px;"
                    transform="translate(1.096 -4.588)"
                />
            </svg>
        </a>
    </div>


    @if(isset($with_credits))
    @include('components.credits')
    @endif;
</footer>
