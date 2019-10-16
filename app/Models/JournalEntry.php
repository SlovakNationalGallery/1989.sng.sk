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
}
