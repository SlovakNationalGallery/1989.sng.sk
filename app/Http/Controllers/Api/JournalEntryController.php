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
        $today = Carbon::today()->year(1989)->endOfDay();
        $activeDatesStart = Carbon::parse('1989-10-01');
        $activeDatesEnd = $today;
        if (backpack_user()) {
            $activeDatesEnd = JournalEntry::orderBy('written_at', 'desc')->first()->written_at;
        }

        $topics = Topic::select('slug', 'name', 'cover_image', 'description')
                ->where([
                    ['category', '<>', 'author']
                ])
                ->active()
                ->visible()
                ->inRandomOrder()
                ->limit(3)
                ->get();

        return JournalEntryResource::make($journalEntry)->additional([
            'meta' => [
                'activeDatesStart' => $activeDatesStart->format('Y-m-d'),
                'activeDatesEnd' => $activeDatesEnd->format('Y-m-d'),
                'topics' => $topics
            ]
        ]);
    }
}
