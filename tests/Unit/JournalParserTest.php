<?php

namespace Tests\Unit;

use Carbon\Carbon;
use App\JournalParser;
use Tests\TestCase;

class JournalParserTest extends TestCase
{
    protected static $parsed;

    public static function setUpBeforeClass(): void
    {
        $journal = new JournalParser(file_get_contents('tests/Fixtures/journal-transcription-10-1989.html'));
        self::$parsed = $journal->parse();
    }

    public function testExtractsDatesFromPages()
    {
        $entries = self::$parsed->entries;

        $this->assertInstanceOf(Carbon::class, $entries[0]->date);
        $this->assertEquals("1989-10-01", $entries[0]->date->format('Y-m-d'));
        $this->assertEquals("1989-10-02", $entries[1]->date->format('Y-m-d'));
        $this->assertEquals("1989-10-04", $entries[3]->date->format('Y-m-d'));
        $this->assertCount(30, $entries);
    }

    public function testExtractsWeatherFromPages()
    {
        $entries = self::$parsed->entries;

        $this->assertEquals("Ráno +12 °C", $entries[0]->weather);
    }

    public function testExtractsRawEntryFromPages()
    {
        $entries = self::$parsed->entries;

        $this->assertStringStartsWith('<p>1.X.1989</p>', $entries[0]->raw);
        $this->assertStringEndsWith("---</p>", $entries[0]->raw);
    }

    public function testRemovesPageDelimitersFromParsedContent()
    {
        $entries = self::$parsed->entries;

        $this->assertStringStartsWith('<p><a href="tag://Nemecká spolková republika">NSR</a>', $entries[0]->content);
        $this->assertStringNotContainsString('---', $entries[0]->content);
        $this->assertStringEndsWith("7 bombových náloží –</p>", $entries[0]->content);
    }

    public function testTurnsTopicTagHrefsIntoLinks()
    {
        $entry = self::$parsed->entries[0];

        $this->assertStringStartsWith('<p><a href="tag://Nemecká spolková republika">NSR</a>', $entry->content);
    }

    public function testExtractsAuthoritativeSubjectForTag()
    {
        $entryWithUnauthoritativeTagSubject = self::$parsed->entries[5];
        $this->assertStringNotContainsString('tag://Miloslav Mečíř', $entryWithUnauthoritativeTagSubject->content);
        $this->assertStringContainsString('tag://Miloslav Měčíř', $entryWithUnauthoritativeTagSubject->content);
    }

    public function testExtractsPagesForEntries()
    {
        $entryEndingMidPage = self::$parsed->entries[0];

        $this->assertContains(557267, $entryEndingMidPage->transcription_page_ids);
        $this->assertContains(557269, $entryEndingMidPage->transcription_page_ids);
        $this->assertContains(557270, $entryEndingMidPage->transcription_page_ids);

        $entryEndingWithPage = self::$parsed->entries[1];
        $this->assertContains(557270, $entryEndingWithPage->transcription_page_ids);
        $this->assertNotContains(557271, $entryEndingWithPage->transcription_page_ids);
    }

    public function testExtractsTagsForEntries()
    {
        $entry = self::$parsed->entries[0];

        $this->assertCount(21, $entry->tags);

        $expectedFirstTag = (object) [
            'id' => 23911,
            'subject' => 'Nemecká spolková republika',
            'categories' => ['krajina'],
        ];

        $expectedLastTag = (object) [
            'id' => 23932,
            'subject' => 'Kozmická obranná iniciatíva',
            'categories' => ['pojem'],
        ];

        $this->assertEquals($expectedFirstTag, $entry->tags[0]);
        $this->assertEquals($expectedLastTag, $entry->tags[20]);
    }

    public function testExtractsGlobalTagAndTagCategories()
    {
        $this->assertCount(486, self::$parsed->tags);
        $this->assertCount(7, self::$parsed->tag_categories);
    }
}
