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

    public function testContentForFrontPage()
    {
        $tag = factory(JournalTag::class)->create(['subject' => 'Tag name']);
        $tag->categories()->attach(factory(JournalTagCategory::class)->create(['name' => 'some category']));
        $tag->categories()->attach(factory(JournalTagCategory::class)->create(['name' => 'another category']));

        $journalEntry = factory(JournalEntry::class)->create([
            'content' => '<a href="tag://Tag name">tag word</a>'
        ]);
        $journalEntry->tags()->attach($tag);

        $this->assertEquals('<span class="journal-entry-tag" data-tag="Tag name" data-tag-categories="some category,another category">tag word</span>', $journalEntry->content_for_frontpage);
    }
}
