<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalTag extends Model
{
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany('App\Models\JournalTagCategory', null, 'tag_id', 'category_id');
    }

}
