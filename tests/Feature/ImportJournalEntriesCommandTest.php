<?php

namespace Tests\Feature;

use App\Models\JournalEntry;
use App\Models\JournalTag;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImportJournalEntriesCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCreatesJournalEntries()
    {
        $this->assertEquals(0, JournalEntry::count());

        $this->runCommand();

        $this->assertEquals(30, JournalEntry::count());
    }

    public function testCreatesJournalTags()
    {
        $this->assertEquals(0, JournalTag::count());

        $this->runCommand();

        $this->assertEquals(486, JournalTag::count());
        $this->assertCount(21, JournalEntry::first()->tags);

        $tag = JournalEntry::first()->tags->first();
        $this->assertEquals(23911, $tag->id);
        $this->assertEquals(['krajina'], $tag->categories->pluck('name')->all());
    }

    private function runCommand() {
        $this->artisan('journal:import', ['path' => 'tests/Fixtures/journal-transcription-10-1989.html']);
    }
}
