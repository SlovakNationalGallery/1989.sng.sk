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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'journal:import {path : path to a fromthepage.com XHTML export}';

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
        $journal = new JournalParser(file_get_contents($this->argument('path')));
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
                $journalEntry->weather = $parsedEntry->weather;
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
