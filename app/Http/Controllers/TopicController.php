<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Topic;
use \App\Models\Item;

class TopicController extends Controller
{
    public function visualEditor(Request $request, $slug)
    {

        $topic = Topic::where('slug', $slug)->firstOrFail();
        return view('visual-editor', [
            'topic' => $topic
        ]);
    }

    public function save(Request $request, $slug)
    {

        $topic = Topic::where('slug', $slug)->firstOrFail();

        $ratio = Item::DEFAULT_WIDTH / $request->input('windowWidth');

        $item_data = $request->input('item');
        $topic->items()->updateExistingPivot($item_data['id'], [
            'width' => $item_data['width'] * $ratio,
            'height' => $item_data['height'] * $ratio,
            'pos_x' => $item_data['pos-x'] * $ratio,
            'pos_y' => $item_data['pos-y'] * $ratio,
            'container' => $item_data['container'] * $ratio,
        ]);

        return response()->json(['response' => 'Saved']);
    }
}
