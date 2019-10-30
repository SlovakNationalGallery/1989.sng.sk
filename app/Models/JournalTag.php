<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalTag extends Model
{
    protected $fillable = ['subject'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\JournalTagCategory', null, 'tag_id', 'category_id');
    }

    public function entries()
    {
        return $this->belongsToMany('App\Models\JournalEntry', null, 'tag_id', 'entry_id');
    }
}
