<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\JournalParser;
use App\Models\JournalEntry;
use App\Models\JournalTranscriptionPage;
use App\Models\JournalTag;
use App\Models\JournalTagCategory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ImportJournalEntriesCommand extends Command
{
    const MONTH_URLS = [
        8 => 'https://fromthepage.com/export/show?work_id=18351',
        9 => 'https://fromthepage.com/export/show?work_id=18350',
        10 => 'https://fromthepage.com/export/show?work_id=17469',
        11 => 'https://fromthepage.com/export/show?work_id=17471',
        12 => 'https://fromthepage.com/export/show?work_id=17501',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '
                            journal:import
                            {month?* : Months to import (e.g. 10 11)}
                            {--all : Imports all months (same as 8 9 10 11 12)}
                            {--path= : Path to a local export}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports JournalEntries from a fromthepage.com XHTML export';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $months = $this->argument('month');

        if ($this->option('path'))
        {
            $this->importJournalEntries($this->option('path'));
            return;
        }

        if (empty($months))
        {
            $this->error('You did not enter a month or a local path');
            return 1;
        }

        foreach ($months as $month)
        {
            if (!array_key_exists($month, self::MONTH_URLS))
            {
                $this->error('Unknown month "' . $month  .'". Valid values: ' . join(" ", array_keys(self::MONTH_URLS)));
                return 1;
            }
        }

        foreach ($months as $month)
        {
            $this->info("Importing month {$month}");
            $this->importJournalEntries(self::MONTH_URLS[$month]);
        }
    }

    private function importJournalEntries($url)
    {
        $journal = new JournalParser(file_get_contents($url));
        $parsedJournal = $journal->parse();

        $this->updateOrCreateTagCategories($parsedJournal->tag_categories);
        $this->updateOrCreateTags($parsedJournal->tags);
        $this->updateorCreateEntries($parsedJournal->entries);
    }

    private function updateOrCreateEntries(array $parsedEntries)
    {
        DB::transaction(function() use ($parsedEntries)
        {
            $allTags = JournalTag::all();

            foreach ($parsedEntries as $parsedEntry)
            {
                $journalEntry = JournalEntry::firstOrNew(['written_at' => $parsedEntry->date->toDateString()]);
                if (!isset($journalEntry->weather)) $journalEntry->weather = $parsedEntry->weather;
                $journalEntry->content = $parsedEntry->content;
                $journalEntry->raw = $parsedEntry->raw;
                $journalEntry->save();

                foreach($parsedEntry->transcription_page_ids as $transcription_page_id)
                {
                    JournalTranscriptionPage::firstOrCreate([
                        'id' => $transcription_page_id
                    ]);
                }

                $entryTagIds = $allTags->whereIn('subject', Arr::pluck($parsedEntry->tags, 'subject'))->pluck('id');

                $journalEntry->tags()->sync($entryTagIds);
                $journalEntry->transcriptionPages()->sync($parsedEntry->transcription_page_ids);
            }
        });
    }

    private function updateOrCreateTags(array $parsedTags)
    {
        DB::transaction(function() use ($parsedTags)
        {
            $allCategories = JournalTagCategory::all();

            foreach($parsedTags as $tag)
            {
                $tagRecord = JournalTag::firstOrCreate(['subject' => $tag->subject]);

                $categoryIds = $allCategories->whereIn('name', $tag->categories)->pluck('id');
                $tagRecord->categories()->sync($categoryIds);
            }
        });
    }

    private function updateOrCreateTagCategories(array $parsedCategories)
    {
        DB::transaction(function() use ($parsedCategories)
        {
            foreach($parsedCategories as $category)
            {
                JournalTagCategory::firstOrCreate(['name' => $category]);
            }
        });
    }
}
