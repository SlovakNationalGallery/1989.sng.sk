<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use Carbon\Carbon;

class DayController extends Controller
{
    const START_DATE = '1989-10-01';
    const END_DATE = '1989-12-01';

    public function index()
    {
        $today = Carbon::today()->year(1989)->endOfDay();

        if (!$today->between(Carbon::parse(self::START_DATE), Carbon::parse(self::END_DATE))) {
            $fallback_date = Carbon::parse('1989-11-17');
            return $this->show($fallback_date->format('Y-m-d'));
        }

        return $this->show($today->format('Y-m-d'));
    }

    public function show($day)
    {
        $selectedDay = Carbon::parse($day);
        $today = Carbon::today()->year(1989)->endOfDay();

        $activeDatesStart = Carbon::parse('1989-10-01');
        $activeDatesEnd = $today;

        if (backpack_user()) {
            $activeDatesEnd = JournalEntry::orderBy('written_at', 'desc')->first()->written_at;
        }

        if (!$selectedDay->between($activeDatesStart, $activeDatesEnd)) return redirect()->route('days.index');

        return view('day', [
            'today' => $today->format('Y-m-d'),
            'selected' => $selectedDay->format('Y-m-d'),
            'startDate' => Carbon::parse(self::START_DATE)->format('Y-m-d'),
            'endDate' => Carbon::parse(self::END_DATE)->format('Y-m-d'),
            'activeDatesStart' => $activeDatesStart->format('Y-m-d'),
            'activeDatesEnd' => $activeDatesEnd->format('Y-m-d'),
        ]);
    }
}
