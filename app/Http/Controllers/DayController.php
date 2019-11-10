<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    public function dayViewParams($date = null)
    {
        $today = Carbon::now()->year(1989)->endOfDay();
        $dt = Carbon::parse($date)->year(1989)->endOfDay();

        if ((Auth::guest() && $today->isBefore($dt)) || !isset($date)) {
            return redirect()->route('day', $today->format('Y-m-d'));
        }

        $query = JournalEntry::orderBy('written_at', 'asc');

        if (Auth::guest()) {
            $tomorrow = Carbon::tomorrow()->year(1989)->endOfDay();
            $query->where('written_at', '<', $tomorrow);
        }

        $days = $query->pluck('written_at');

        $entries = JournalEntry::where('written_at', '=', $date)->get();

        return view('day', [
            'date' => $date,
            'days' => $days,
            'entries' => $entries,
            'today' => $today->format('Y-m-d')
        ]);
    }
}
