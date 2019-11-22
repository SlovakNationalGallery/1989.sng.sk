<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Exception;

class JournalEntry extends Model
{
    use CrudTrait;

    protected $fillable = [
        'written_at',
        'weather',
        'excerpt',
        'content',
        'zatkuliak',
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

    public function setExcerptAttribute($value)
    {
        $this->attributes['excerpt'] = preg_replace_callback('/"tag:\/\/(.+?)"/m', function ($matches) {
            $tag = urldecode($matches[1]);
            return "\"tag://$tag\"";
        }, $value);
    }

    public function getContentFormattedAttribute()
    {
        return $this->formatForDisplay($this->content);
    }

    public function getExcerptFormattedAttribute()
    {
        if (!$this->excerpt) return null;
        return $this->formatForDisplay($this->excerpt);
    }

    public function getWrittenAtRomanizedAttribute()
    {
        $romanNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $monthRomanized = $romanNumbers[$this->written_at->month - 1];
        return $this->written_at->format("d."). " $monthRomanized. " . $this->written_at->format("Y");
    }

    private function formatForDisplay($content)
    {
        $tagsCategories = [];
        foreach ($this->tags()->with('categories')->get() as $tag) {
            $tagsCategories[$tag->subject] = $tag->categories->pluck('name')->all();
        };

        return preg_replace_callback('/<a\s+href="tag:\/\/(.+?)">((.|\n)*?)<\/a>/m', function ($matches) use ($tagsCategories) {
            $tag = $matches[1];

            if (isset($tagsCategories[$tag])) {
                $categories = join(',', $tagsCategories[$tag]);
                return "<a tabindex=\"0\" data-tag=\"$tag\" data-tag-categories=\"$categories\" class=\"journal-entry-tag\" >$matches[2]</a>";
            } else {
                return $matches[2];
            }
        }, $content);
    }
}
