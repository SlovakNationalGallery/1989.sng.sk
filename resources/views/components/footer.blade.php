<div id="footer" class="container">
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
                Nové témy <br/>pribudnú čoskoro
            </h3>
        </div>
    </div>

</div>