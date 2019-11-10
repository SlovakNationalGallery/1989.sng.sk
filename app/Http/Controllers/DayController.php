<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Carbon\Carbon;

class DayController extends Controller
{
    public function dayViewParams($date)
    {
        $days = JournalEntry::orderBy('written_at', 'asc')->pluck('written_at');

        $entries = JournalEntry::where('written_at', '=', $date)->get();
        $today = Carbon::now()->year(1989)->format('Y-m-d');

        if ($entries->count() > 0) {
            return view('day', [
                'date' => $date,
                'days' => $days,
                'entries' => $entries,
                'today' => $today
            ]);
        } else {
            return redirect()->route('day', isset($days->start) ? $days->start : '1989-11-1');
        }
    }
}
