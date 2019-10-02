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

    public function transcriptionPages()
    {
        return $this->belongsToMany('App\Models\JournalTranscriptionPage');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\JournalTag');
    }

    public function getFormattedContent()
    {
        // TODO link to actual path
        return preg_replace('/href="topic:\/\/(.+?)"/', 'href="/path/to/topic/${1}"', $this->content);
    }
}
