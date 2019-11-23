<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\JournalEntry;
use App\Models\Topic;
use App\Http\Resources\JournalEntryCollection;
use App\Http\Resources\JournalEntry as JournalEntryResource;
use App\Models\JournalTag;

class JournalEntryController extends Controller
{
    public function index(Request $request)
    {
        $tag = JournalTag::where('subject', $request->query('tag'))->first();
        $journalEntries = JournalEntry::whereHas('tags', function($query) use ($tag) {
            if ($tag) $query->where('subject', $tag->subject);
        })->orderBy('written_at', 'asc')->get();

        $response = new JournalEntryCollection($journalEntries);
        if ($tag) $response = $response->additional([
            'data' => [
                'tag' => [
                    'categories' => $tag->categories->pluck('name')
                ]
            ]
        ]);

        return $response;
    }

    public function show(JournalEntry $journalEntry)
    {
        return JournalEntryResource::make($journalEntry);
    }
}
