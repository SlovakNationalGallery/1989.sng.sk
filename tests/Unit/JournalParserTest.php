<?php

namespace Tests\Unit;

use App\JournalParser;
use Tests\TestCase;

class JournalParserTest extends TestCase
{
    public function testExtractsDatesFromPages()
    {
        $html = file_get_contents(base_path() . '/tests/Unit/fixtures/10-1989.html');
        $parsed = JournalParser::parse($html);

        $this->assertEquals("1.X.1989", $parsed[0]->date_raw);
        $this->assertInstanceOf(\DateTime::class, $parsed[0]->date);
        $this->assertEquals("1989-10-01", $parsed[0]->date->format('Y-m-d'));

        $this->assertEquals("4. X. 1989", $parsed[3]->date_raw);
        $this->assertEquals("1989-10-04", $parsed[3]->date->format('Y-m-d'));
        $this->assertCount(30, $parsed);
    }

    public function testExtractsWeatherFromPages()
    {
        $html = file_get_contents(base_path() . '/tests/Unit/fixtures/10-1989.html');
        $parsed = JournalParser::parse($html);

        $this->assertEquals("***Ráno +12 °C***", $parsed[0]->weather_raw);
        $this->assertEquals("Ráno +12 °C", $parsed[0]->weather);
    }
}
