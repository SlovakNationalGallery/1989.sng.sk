<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use DB;

class DayController extends Controller
{
    public function dayViewParams($date)
    {
        $days = JournalEntry::selectRaw(' MIN(written_at) as start, MAX(written_at) as end')->first();

        $entries = JournalEntry::where('written_at', '=', $date)->get();

        if ($entries->count() > 0) {
            return view('day', [
                'date' => $date,
                'daysAvailable' => json_encode($days),
                'entries' => json_encode($entries)
            ]);
        } else {
            return redirect()->route('day', isset($days->start) ? $days->start : '1989-11-1');
        }
    }
}
