<div id="footer" class="container">

    @foreach (App\Models\Topic::$available_categories as $catKey => $cat)
    @if (isset($topics[$catKey]))
    <dl>
        <dt>{!! $cat !!}</dt>
        @foreach ($topics[$catKey]->all() as $topic)
        @if ($topic->is_active)
            <dd><a href="#TODO">{!! $topic->name!!}</a></dd>
        @else
            <dd class="inactive">{!! $topic->name!!}</dd>
        @endif
        @endforeach
    </dl>
    @endif
    @endforeach

</div>