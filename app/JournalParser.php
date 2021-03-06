<?php

namespace App;

use Carbon\Carbon;
use DOMElement;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

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
            if ($p->isDate()) {
                if ($entry) $this->entries[] = $entry;

                $entry = new Entry($p);
                $entry->date = $p->getParsedDate();
                $entry->raw = $p->ownerDocument->saveHTML($p);

                continue;
            }

            if (!in_array($p->getTranscriptionPageId(), $entry->transcription_page_ids)) {
                array_push($entry->transcription_page_ids, $p->getTranscriptionPageId());
            }

            foreach ($this->xpath->query('a', $p) as $a) {
                $tagId = (int) substr($a->getAttribute('href'), strlen('#article-'));
                $tag = $this->tags[$tagId];

                if ($entry->hasTag($tag)) continue;
                array_push($entry->tags, $tag);
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

            $entry->content .= $p->getParsedContent($this->tags);
        }

        $this->entries[] = $entry;
    }

    private function parseTagsAndCategories()
    {
        foreach ($this->xpath->query('//div[@class="subjects"]/div') as $tagNode)
        {
            $id = (int) substr($tagNode->attributes['id']->value, strlen('article-'));

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
        // Exception due to source typo at https://fromthepage.com/lab-sng/december-1989/12-december/display/557798
        if ($this->textContent == '7. XII. 1') return true;
        return preg_match('/^\s*\d{1,2}\.\s?[XIV]{1,4}\.\s?1989\s*$/', $this->textContent);
    }

    public function getParsedDate()
    {
        if ($this->textContent == '7. XII. 1') return new Carbon('1989-12-07');

        $trimmed = preg_replace('/\s/', '', $this->textContent);
        $trimmed = str_replace('.VIII.', '.8.', $trimmed);
        $trimmed = str_replace('.IX.', '.9.', $trimmed);
        $trimmed = str_replace('.X.',  '.10.', $trimmed);
        $trimmed = str_replace('.XI.', '.11.', $trimmed);
        $trimmed = str_replace('.XII.', '.12.', $trimmed);

        return Carbon::createFromFormat('d.m.Y', $trimmed);
    }

    public function isWeather()
    {
        return preg_match('/\A\s*\*\*\*.+?\*\*\*\s*\Z/s', $this->textContent);
    }

    public function isPageDelimiter()
    {
        return preg_match('/^\s*---\s*$/', $this->textContent);
    }

    public function getParsedWeather()
    {
        $trimmed = str_replace('***', '', $this->textContent);
        $trimmed = preg_replace('/\s+/s', ' ', $trimmed);
        $trimmed = trim($trimmed);
        return $trimmed;
    }

    public function getParsedContent($allTags)
    {
        $parsed = str_replace('---', "\n", $this->ownerDocument->saveHTML($this));

        $parsed = preg_replace_callback(
            '/<a\s+href="#article-(\d+?)".+?>/m',
            function ($matches) use ($allTags)
            {
                $tagSubject = $allTags[$matches[1]]->subject;
                return "<a href=\"tag://$tagSubject\">";
            },
            $parsed);
        return $parsed;
    }

    public function getTranscriptionPageId()
    {
        return (int) substr($this->parentNode->parentNode->getAttribute('id'), strlen('page-'));
    }
}
