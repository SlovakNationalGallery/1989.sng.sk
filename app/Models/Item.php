<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

use Illuminate\Support\Str;

class Item extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'items';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'type',
        'text',
        'file',
        'video',
        'source',
        'author',
        'author_role',
        'author_image',
        'iip_path',
        'year',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'video' => 'object',
    ];

    const COMPONENT_PREFIX = 'components.items.';

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getComponent()
    {
        $component = '';

        switch ($this->type) {
            case 'image':
                $component = 'image';
                break;

            case 'video':
                $component = 'video';
                break;

            default:
                $component = 'text';
                break;
        }

        return self::COMPONENT_PREFIX . $component;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function topics()
    {
        return $this->belongsToMany('App\Models\Topic')->using('App\Models\ItemTopic')->withPivot('order');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute()
    {
        $full_name = ($this->author) ? $this->author . ' – ' . $this->name : $this->name;
        if (($this->year) && Str::contains($full_name, [$this->year])) {
            $full_name .= '(' . $this->year . ')';
        }

        return $full_name;
    }

    public function getPreviewAttribute()
    {
        // @todo: return smallest variant of image

        if ($this->file) {
            return $this->file;
        } elseif ($this->video && (!empty($this->video->image))) {
            return $this->video->image;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
