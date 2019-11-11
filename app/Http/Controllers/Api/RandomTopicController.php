<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use \App\Models\Topic;

class RandomTopicController extends Controller
{

    public function get()
    {
        return response()->json(
            Topic::select('slug', 'name', 'cover_image', 'description')
                ->where([
                    ['category', '<>', 'author']
                ])
                ->active()
                ->visible()
                ->inRandomOrder()
                ->limit(3)
                ->get()
        );
    }
}
