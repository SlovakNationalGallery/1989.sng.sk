<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\JournalTag;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function index(Request $request)
    {
        $tag = JournalTag::where('subject', $request->input('tag'))->firstOrFail();
        $entries = $tag->entries;
        return view('journal_entries.index', compact(['tag', 'entries']));
    }

    public function show(JournalEntry $journalEntry)
    {
        return view('journal_entries.show', ['entry' => $journalEntry]);
    }
}
