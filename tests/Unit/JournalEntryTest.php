<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\JournalEntry;
use App\Models\Topic;

class JournalEntryTest extends TestCase
{
    use RefreshDatabase;

    public function testTopicLinksRenderWithTopicUrl()
    {
        $topic = factory(Topic::class)->create([
            'name' => 'Topic name',
            'slug' => 'topic-slug',
        ]);

        $journalEntry = factory(JournalEntry::class)->create([
            'content' => '<a href="topic://Topic name">topic</a>'
        ]);

        $this->assertEquals('<a href="' . route('topic', $topic->slug) . '">topic</a>', $journalEntry->content_formatted);
    }

    public function testUndefinedTopicLinksRenderAsPlainText()
    {
        $journalEntry = factory(JournalEntry::class)->create([
            'content' => '<a href="topic://Undefined Topic">text</a>'
        ]);

        $this->assertEquals('text', $journalEntry->content_formatted);
    }
}
