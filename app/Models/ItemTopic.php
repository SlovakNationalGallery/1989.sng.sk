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

    const DEFAULT_CONTAINER_WIDTH = 1280;
    const DEFAULT_WIDTH = 400;
    const DEFAULT_HEIGHT = 200;
    const DEFAULT_MARGIN = 50;


    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->order === null) {
                $max_order = self::where('topic_id', $model->topic_id)->max('order');
                $model->order = ($max_order !== null) ? ++$max_order : 0;
            }

            // set default size and position

            $item = \App\Models\Item::find($model->item_id);

            if ($item->video && isSet($item->video->width) && isSet($item->video->height)) {
                $model->setDefaultSizeAndPosition(null, $item->video->width, $item->video->height);
            } else {
                $model->setDefaultSizeAndPosition($item->file);
            }
        });

        // @TODO - apply reordering after deleting from pivot table for items with order > $model->order
    }

    public function setDefaultSizeAndPosition($file = null, $full_width = null, $full_height = null)
    {
        $width = self::DEFAULT_WIDTH;
        $height = self::DEFAULT_HEIGHT;

        if ($file && file_exists(public_path($file)) ) {
            list($full_width, $full_height) = getimagesize(public_path($file));
        }

        if (isSet($full_width) && isSet($full_height)) {
            $height = $full_height * ($width / $full_width);
        }

        $pos_x = intval(round((self::DEFAULT_CONTAINER_WIDTH / 2) - ($width / 2))); // center
        $pos_y = 0;

        $container = $height + self::DEFAULT_MARGIN;

        $this->width = $width;
        $this->height = $height;
        $this->pos_x = $pos_x;
        $this->pos_y = $pos_y;
        $this->container = $container;
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
