<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class JournalEntry extends Model
{
    use CrudTrait;

    protected $dates = [
        'written_at',
    ];

    public function getFormattedContent()
    {
        // TODO link to actual path
        return preg_replace('/href="topic:\/\/(.+?)"/', 'href="/path/to/topic/${1}"', $this->content);
    }
}
