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

    public function getContentForFrontpageAttribute() {
        $tagsCategories = [];
        foreach($this->tags()->with('categories')->get() as $tag) {
            $tagsCategories[$tag->subject] = $tag->categories->pluck('name')->all();
        };

        return preg_replace_callback('/<a\s+href="tag:\/\/(.+?)">((.|\n)*?)<\/a>/m', function($matches) use ($tagsCategories) {
            $tag = $matches[1];
            $categories = join(',', $tagsCategories[$tag]);

            return "<span class=\"journal-entry-tag\" data-tag=\"$tag\" data-tag-categories=\"$categories\">$matches[2]</span>";
        }, $this->content);
    }
}
