<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use App\Models\Topic;

class JournalEntry extends Model
{
    use CrudTrait;

    protected $fillable = [
        'written_at',
    ];

    protected $dates = [
        'written_at',
    ];

    public function transcriptionPages()
    {
        return $this->belongsToMany('App\Models\JournalTranscriptionPage');
    }

    public function getContentFormattedAttribute()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadHTML(mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        $xpath = new \DOMXPath($dom);

        $existingTopics = $this->existing_mentioned_topics;

        foreach ($xpath->query("//a[starts-with(@href, 'topic://')]") as $a)
        {
            $topicName = substr($a->getAttribute('href'), 8);
            $topic = $existingTopics->where('name', $topicName)->first();

            if ($topic)
            {
               $a->setAttribute('href', route('topic', $topic->slug));
               continue;
            }

            $a->parentNode->replaceChild($dom->createTextNode($a->textContent), $a);
        }

        return trim($dom->saveHTML($dom->documentElement));
    }

    protected function getExistingMentionedTopicsAttribute()
    {
        $topics = [];
        preg_match_all('/href="topic:\/\/(.+?)"/', $this->content, $topics);
        $topicNames = array_unique($topics[1]);
        return Topic::whereIn('name', $topicNames)->get();
    }
}
