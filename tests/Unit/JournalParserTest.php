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
        self::$parsed = JournalParser::parse(file_get_contents('tests/Fixtures/journal-transcription-10-1989.html'));
    }

    public function testExtractsDatesFromPages()
    {
        $parsed = self::$parsed;

        $this->assertInstanceOf(Carbon::class, $parsed[0]->date);
        $this->assertEquals("1989-10-01", $parsed[0]->date->format('Y-m-d'));
        $this->assertEquals("1989-10-02", $parsed[1]->date->format('Y-m-d'));
        $this->assertEquals("1989-10-04", $parsed[3]->date->format('Y-m-d'));
        $this->assertCount(30, $parsed);
    }

    public function testExtractsWeatherFromPages()
    {
        $parsed = self::$parsed;

        $this->assertEquals("Ráno +12 °C", $parsed[0]->weather);
    }

    public function testExtractsRawEntryFromPages()
    {
        $parsed = self::$parsed;

        $this->assertStringStartsWith('<p>1.X.1989</p>', $parsed[0]->raw);
        $this->assertStringEndsWith("---</p>", $parsed[0]->raw);
    }

    public function testRemovesPageDelimitersFromParsedContent()
    {
        $parsed = self::$parsed;

        $this->assertStringStartsWith('<p><a href="topic://Nemecká spolková republika">NSR</a>', $parsed[0]->content);
        $this->assertStringNotContainsString('---', $parsed[0]->content);
        $this->assertStringEndsWith("7 bombových náloží –</p>", $parsed[0]->content);
    }

    public function testTurnsTopicTagHrefsIntoLinks()
    {
        $this->assertStringStartsWith('<p><a href="topic://Nemecká spolková republika">NSR</a>', self::$parsed[0]->content);
    }

    public function testExtractsPagesForEntries()
    {
        $parsed = self::$parsed;

        $this->assertContains(557267, $parsed[0]->transcription_page_ids);
        $this->assertContains(557269, $parsed[0]->transcription_page_ids);
        $this->assertContains(557270, $parsed[0]->transcription_page_ids);
    }

    public function testExtractsTagsForEntries()
    {
        $entry = self::$parsed[0];

        $this->assertCount(21, $entry->tags);

        $expectedFirstTag = (object) [
            'id' => 23911,
            'subject' => 'Nemecká spolková republika',
        ];

        $expectedLastTag = (object) [
            'id' => 23932,
            'subject' => 'Kozmická obranná iniciatíva',
        ];

        $this->assertEquals($expectedFirstTag, $entry->tags[0]);
        $this->assertEquals($expectedLastTag, $entry->tags[20]);
    }
}
