<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ItemTopic extends Pivot
{

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $max_order = self::where('topic_id', $model->topic_id)->max('order');
            $model->order = ($max_order !== null) ? ++$max_order : 0;
        });

        // @TODO - apply reordering after deleting from pivot table for items with order > $model->order
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


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

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}