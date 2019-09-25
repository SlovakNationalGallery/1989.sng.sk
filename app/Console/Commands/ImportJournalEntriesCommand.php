<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\JournalParser;
use App\Models\JournalEntry;
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
        $html = file_get_contents($this->argument('path'));
        $parsed_entries = JournalParser::parse($html);

        DB::transaction(function () use ($parsed_entries)
        {
            foreach ($parsed_entries as $parsed_entry)
            {
                $journal_entry = JournalEntry::firstOrNew(['written_at' => $parsed_entry->date->toDateString()]);
                $journal_entry->weather = $parsed_entry->weather;
                $journal_entry->content = $parsed_entry->content;

                $journal_entry->written_at_raw = $parsed_entry->date_raw;
                $journal_entry->weather_raw = $parsed_entry->weather_raw;
                $journal_entry->content_raw = $parsed_entry->content_raw;

                $journal_entry->save();
            }
        });

    }
}
