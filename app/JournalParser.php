<?php

namespace App;

use Carbon\Carbon;
use DOMElement;
use Illuminate\Support\Arr;

class JournalParser
{
    private $dom;
    private $xpath;

    private $entries;
    private $tags;
    private $tag_categories;

    public function __construct($xhtml)
    {
        $dom = new \DOMDocument;
        $dom->registerNodeClass(DOMElement::class, JournalDOMElement::class);
        $dom->loadHTML($xhtml);

        $this->dom = $dom;
        $this->xpath = new \DOMXPath($dom);

        $this->entries = [];
        $this->tags = [];
        $this->tag_categories = [];
    }

    public function parse()
    {
        $this->parseTagsAndCategories();
        $this->parseEntries();

        return (object) [
            'entries' => $this->entries,
            'tags' => $this->tags,
            'tag_categories' => $this->tag_categories,
        ];
    }

    private function parseEntries()
    {
        $entry = null;

        foreach ($this->xpath->query('//div[@class="pages"]/div/div[@class="page-content"]/p') as $p) {
            if ($entry) {
                if (!in_array($p->getTranscriptionPageId(), $entry->transcription_page_ids)) {
                    array_push($entry->transcription_page_ids, $p->getTranscriptionPageId());
                }

                foreach ($this->xpath->query('a', $p) as $a) {
                    $tagId = (int) substr($a->getAttribute('href'), 9);
                    $tag = $this->tags[$tagId];

                    if ($entry->hasTag($tag)) continue;
                    array_push($entry->tags, $tag);
                }
            }

            if ($p->isDate()) {
                if ($entry) $this->entries[] = $entry;

                $entry = new Entry($p);
                $entry->date = $p->getParsedDate();
                $entry->raw = $p->ownerDocument->saveHTML($p);

                continue;
            }

            $entry->raw .= $p->ownerDocument->saveHTML($p);

            if ($p->isWeather()) {
                $entry->weather = $p->getParsedWeather();
                continue;
            }

            if ($p->isPageDelimiter()) {
                // no-op
                continue;
            }

            $entry->content .= $p->getParsedContent();
        }

        $this->entries[] = $entry;
    }

    private function parseTagsAndCategories()
    {
        foreach ($this->xpath->query('//div[@class="subjects"]/div') as $tagNode)
        {
            $id = (int) substr($tagNode->attributes['id']->value, 8);

            if (array_key_exists($id, $this->tags)) continue;

            $categoryNodes = $this->xpath->query('./div[@class="article-categories"]/ul/li/small/child::node()', $tagNode);
            $categories = Arr::pluck($categoryNodes, 'wholeText');

            foreach ($categories as $category)
            {
                if (!in_array($category, $this->tag_categories)) $this->tag_categories[] = $category;
            }

            $this->tags[$id] = (object) [
                'id' => $id,
                'subject' => $this->xpath->evaluate('string(./h3[@class="article-title"][1])', $tagNode),
                'categories' => $categories,
            ];
        }
    }
}

class Entry
{
    public $date;
    public $weather;
    public $content;
    public $raw;
    public $transcription_page_ids;
    public $tags;

    public function __construct()
    {
        $this->content = '';
        $this->transcription_page_ids = [];
        $this->tags = [];
    }

    public function hasTag($tag)
    {
        return in_array($tag->id, Arr::pluck($this->tags, 'id'));
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
