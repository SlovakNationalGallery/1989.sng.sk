<?php

namespace App;

use Carbon\Carbon;
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
            if ($entry) {
                if (!in_array($p->getTranscriptionPageId(), $entry['transcription_page_ids'])) {
                    array_push($entry['transcription_page_ids'], $p->getTranscriptionPageId());
                }
            }

            if ($p->isDate()) {
                if ($entry) array_push($entries, (object) $entry);

                $entry = [
                    'date' => $p->getParsedDate(),
                    'weather' => null,
                    'content' => '',
                    'raw' => $p->ownerDocument->saveHTML($p),
                    'transcription_page_ids' => [],
                ];
                continue;
            }

            $entry['raw'] .= $p->ownerDocument->saveHTML($p);

            if ($p->isWeather()) {
                $entry['weather'] = $p->getParsedWeather();
                continue;
            }

            if ($p->isPageDelimiter()) {
                // TODO
                continue;
            }

            $entry['content'] .= $p->getParsedContent();
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

        return Carbon::createFromFormat('d.m.Y', $trimmed);
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
        $parsed = str_replace('---', "\n", $this->ownerDocument->saveHTML($this));
        $parsed = preg_replace('/<a\s+href="#article-\d+"\s+title="(.+?)">/m', '<a href="topic://${1}">', $parsed);
        return $parsed;
    }

    public function getTranscriptionPageId()
    {
        return (int) substr($this->parentNode->parentNode->getAttribute('id'), 5);
    }
}
