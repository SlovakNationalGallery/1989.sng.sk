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
        self::$parsed = JournalParser::parse(file_get_contents('tests/Unit/fixtures/10-1989.html'));
    }

    public function testExtractsDatesFromPages()
    {
        $parsed = self::$parsed;

        $this->assertEquals("1.X.1989", $parsed[0]->date_raw);
        $this->assertInstanceOf(Carbon::class, $parsed[0]->date);
        $this->assertEquals("1989-10-01", $parsed[0]->date->format('Y-m-d'));

        $this->assertEquals("4. X. 1989", $parsed[3]->date_raw);
        $this->assertEquals("1989-10-04", $parsed[3]->date->format('Y-m-d'));
        $this->assertCount(30, $parsed);
    }

    public function testExtractsWeatherFromPages()
    {
        $parsed = self::$parsed;

        $this->assertEquals("***Ráno +12 °C***", $parsed[0]->weather_raw);
        $this->assertEquals("Ráno +12 °C", $parsed[0]->weather);
    }

    public function testExtractsContentHTMLFromPages()
    {
        $parsed = self::$parsed;

        $this->assertStringStartsWith('<p><a href="#article-23911" title="Nemecká spolková republika">NSR</a>', $parsed[0]->content_raw);
        $this->assertStringEndsWith("---</p>", $parsed[0]->content_raw);
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
}
