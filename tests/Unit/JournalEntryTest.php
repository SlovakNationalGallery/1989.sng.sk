<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\JournalEntry;
use App\Models\JournalTag;
use App\Models\JournalTagCategory;

class JournalEntryTest extends TestCase
{
    use RefreshDatabase;

    public function testContentFormattedAttribute()
    {
        $tag = factory(JournalTag::class)->create(['subject' => 'Tag name']);
        $tag->categories()->attach(factory(JournalTagCategory::class)->create(['name' => 'some category']));
        $tag->categories()->attach(factory(JournalTagCategory::class)->create(['name' => 'another category']));

        $journalEntry = factory(JournalEntry::class)->create([
            'content' => '<a href="tag://Tag name">tag word</a>'
        ]);
        $journalEntry->tags()->attach($tag);

        $this->assertEquals(
            '<a tabindex="0" data-tag="Tag name" data-tag-categories="some category,another category" data-date="' . $journalEntry->written_at->toDateString() . '" class="journal-entry-tag">tag word</a>',
            $journalEntry->content_formatted
        );
    }
}
