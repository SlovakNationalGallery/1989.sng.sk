<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

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
        'source',
        'author',
        'author_role',
        'author_image',
        'iip_path',
        'year',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    const COMPONENT_PREFIX = 'components.items.';
    const DEFAULT_WIDTH = 1280;
    const DEFAULT_MARGIN = 40;

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
        $full_name = ($this->author) ? $this->author . ': ' . $this->name : $this->name;
        $full_name .= ($this->year) ? ' (' . $this->year . ')' : '';
        return $full_name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
