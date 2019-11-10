<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Topic;
use \App\Models\ItemTopic;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware(\Backpack\Base\app\Http\Middleware\CheckIfAdmin::class, ['except' => ['show']]);
    }

    public function show(Topic $topic)
    {
        if (!$topic->is_active) abort(404);

        $nextTopic = $topic->nextTopic()->active()->first();
        $previousTopic = $topic->previousTopic()->active()->first();

        return view('topics/show', compact('topic', 'nextTopic', 'previousTopic'));
    }

    public function edit(Topic $topic)
    {
        $nextTopic = $topic->nextTopic;
        $previousTopic = $topic->previousTopic;
        return view('topics/edit', compact('topic', 'nextTopic', 'previousTopic'));
    }

    public function update(Topic $topic, Request $request)
    {
        $ratio = ItemTopic::DEFAULT_CONTAINER_WIDTH / $request->input('windowWidth');

        $items_data = $request->input('items');
        foreach ($items_data as $id => $item) {
            $items_data[$id] = [
                'width' => $item['width'] * $ratio,
                'height' => $item['height'] * $ratio,
                'pos_x' => $item['pos-x'] * $ratio,
                'pos_y' => $item['pos-y'] * $ratio,
                'container' => $item['container'] * $ratio,
            ];
        }

        $topic->items()->sync($items_data);

        return response()->json(['response' => 'Saved']);
    }
}
