<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\JournalEntry;
use App\Models\Topic;
use App\Http\Resources\JournalEntryCollection;
use App\Http\Resources\JournalEntry as JournalEntryResource;


class JournalEntryController extends Controller
{
    public function index(Request $request)
    {
        $tag = $request->query('tag');
        $journalEntries = JournalEntry::whereHas('tags', function ($query) use ($tag) {
            if ($tag) $query->where('subject', $tag);
        })->get();

        return new JournalEntryCollection($journalEntries);
    }

    public function show(JournalEntry $journalEntry)
    {
        return JournalEntryResource::make($journalEntry);
    }
}
