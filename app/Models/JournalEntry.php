<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class JournalEntry extends Model
{
    use CrudTrait;

    protected $fillable = [
        'written_at',
    ];

    protected $dates = [
        'written_at',
    ];

    public function getRouteKeyName()
    {
        return 'written_at';
    }

    public function transcriptionPages()
    {
        return $this->belongsToMany('App\Models\JournalTranscriptionPage');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\JournalTag', null, 'entry_id', 'tag_id');
    }

    public function getContentFormattedAttribute()
    {
        return preg_replace_callback('/href="topic:\/\/(.+?)"/', function($matches) {
            return 'href="' . route('journal-entries.index', ['tag' => $matches[1]]) . '" ' .
                   'title="' . $matches[1] . '"';
        }, $this->content);
    }

    public function getWrittenAtFormattedAttribute()
    {
        $romanConversion = [
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return join('. ', [$this->written_at->day, $romanConversion[$this->written_at->month], $this->written_at->year]);
    }
}
