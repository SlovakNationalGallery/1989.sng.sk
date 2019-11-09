<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;

class DayController extends Controller
{
    public function dayViewParams($date)
    {
        $days = JournalEntry::orderBy('written_at', 'asc')->pluck('written_at');

        $entries = JournalEntry::where('written_at', '=', $date)->get();

        if ($entries->count() > 0) {
            return view('day', [
                'date' => $date,
                'days' => $days,
                'entries' => $entries
            ]);
        } else {
            return redirect()->route('day', isset($days->start) ? $days->start : '1989-11-1');
        }
    }
}
