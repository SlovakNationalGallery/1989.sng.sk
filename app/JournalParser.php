<?php

namespace App;

use DOMElement;

class JournalParser
{
    public static function parse($xhtml)
    {
        $dom = new \DOMDocument;
        $dom->registerNodeClass(DOMElement::class, JournalDOMElement::class);

        $dom->loadHTML($xhtml);
        $xpath = new \DOMXPath($dom);

        $entries = array();
        $entry = null;

        foreach ($xpath->query("//div[@class='pages']/div/div[@class='page-content']/p") as $p) {
            if ($p->isDate()) {
                if ($entry) array_push($entries, (object) $entry);

                $entry = [
                    'date_raw' => $p->textContent,
                    'date' => $p->getParsedDate(),
                    'content_raw' => '',
                    'content' => '',
                    'weather_raw' => null,
                    'weather' => null,
                ];
                continue;
            }

            if ($p->isWeather()) {
                $entry['weather_raw'] = $p->textContent;
                $entry['weather'] = $p->getParsedWeather();
                continue;
            }

            if ($p->isPageDelimiter()) {
                $entry['content_raw'] .= $p->ownerDocument->saveHTML($p);
                continue;
            }

            $entry['content'] .= $p->getParsedContent();
            $entry['content_raw'] .= $p->ownerDocument->saveHTML($p);
        }

        array_push($entries, (object) $entry);

        return $entries;
    }
}

class JournalDOMElement extends DOMElement
{
    public function isDate()
    {
        return preg_match('/^\s*\d{1,2}\.\s?[XI]{1,2}\.\s?1989\s*$/', $this->textContent);
    }

    public function getParsedDate()
    {
        $trimmed = preg_replace('/\s/', '', $this->textContent);
        $trimmed = str_replace('.IX.', '.9.', $trimmed);
        $trimmed = str_replace('.X.',  '.10.', $trimmed);
        $trimmed = str_replace('.XI.', '.11.', $trimmed);

        return \DateTime::createFromFormat('d.m.Y', $trimmed);
    }

    public function isWeather()
    {
        return preg_match('/^\s*\*\*\*.+\*\*\*\s*$/', $this->textContent);
    }

    public function isPageDelimiter()
    {
        return preg_match('/^\s*---\s*$/', $this->textContent);
    }

    public function getParsedWeather()
    {
        $trimmed = str_replace('***', '', $this->textContent);
        $trimmed = trim($trimmed);
        return $trimmed;
    }

    public function getParsedContent()
    {
        return str_replace('---', '\n', $this->ownerDocument->saveHTML($this));
    }
}
