<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Topic;

class TopicController extends Controller
{
    public function visualEditor(Request $request, $slug)
    {

        $topic = Topic::where('slug', $slug)->firstOrFail();
        return view('visual-editor', [
            'topic' => $topic
        ]);
    }
}
