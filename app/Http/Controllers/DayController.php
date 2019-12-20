<?php

namespace App\Http\Controllers;

use App\Models\JournalEntry;
use App\Models\Topic;
use Carbon\Carbon;
use App\Http\Resources\JournalEntry as JournalEntryResource;

class DayController extends Controller
{
    const START_DATE = '1989-09-01';
    const END_DATE = '1989-12-31';
    const FALLBACK_DATE = '1989-11-17';

    public function index()
    {
        $today = Carbon::today()->year(1989)->endOfDay();

        if (!$today->between(Carbon::parse(self::START_DATE), Carbon::parse(self::END_DATE))) {
            return $this->show(Carbon::parse(self::FALLBACK_DATE)->format('Y-m-d'));
        }

        return $this->show($today->format('Y-m-d'));
    }

    public function show($day)
    {
        return view('day', self::data($day));
    }

    public function data($day)
    {
        $activeDatesStart = Carbon::parse(self::START_DATE);
        $activeDatesEnd = Carbon::parse(self::END_DATE)->endOfDay();

        $selectedDay = Carbon::parse($day);
        $today = Carbon::today()->year(1989);

        $selectedDay = $selectedDay->between($activeDatesStart, $activeDatesEnd) ? $selectedDay : Carbon::parse(self::FALLBACK_DATE);
        $today = $today->between($activeDatesStart, $activeDatesEnd) ? $today : null;

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

        $journalEntry =  JournalEntry::where('written_at', $selectedDay->format('Y-m-d'))->first();

        return [
            'topics' => $topics,
            'journalEntry' => JournalEntryResource::make($journalEntry),
            'today' => isset($today) ? $today->format('Y-m-d') : null,
            'selected' => $selectedDay->format('Y-m-d'),
            'startDate' => Carbon::parse(self::START_DATE)->format('Y-m-d'),
            'endDate' => Carbon::parse(self::END_DATE)->format('Y-m-d'),
            'activeDatesStart' => $activeDatesStart->format('Y-m-d'),
            'activeDatesEnd' => $activeDatesEnd->format('Y-m-d'),
        ];
    }
}
