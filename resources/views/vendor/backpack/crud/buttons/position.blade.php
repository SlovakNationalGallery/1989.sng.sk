@if ($crud->hasAccess('update'))
<a href="{{ route('topic.editor', ['slug' => $entry->slug]) }} " class="btn btn-xs btn-default"><i class="fa fa-arrows"></i> Visual editor</a>
@endif