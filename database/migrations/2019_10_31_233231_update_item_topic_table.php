<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateItemTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_topic', function (Blueprint $table) {
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('container')->nullable();
            $table->integer('pos_x')->nullable();
            $table->integer('pos_y')->nullable();
        });

        // @todo: set default numbers
        $topics = \App\Models\Topic::all();
        foreach ($topics as $topic) {
            foreach ($topic->items as $item) {
                $width = 400;
                $height = 200;

                if ($item->file && file_exists(public_path($item->file)) ) {
                    list($full_width, $full_height) = getimagesize(public_path($item->file));
                    $height = $full_height * ($width / $full_width);
                }

                $pos_x = 0;
                $pos_y = 50;

                $container = $height + \App\Models\Item::DEFAULT_MARGIN;

                $topic->items()->updateExistingPivot($item->id, [
                    'width' => $width,
                    'height' => $height,
                    'pos_x' => $pos_x,
                    'pos_y' => $pos_y,
                    'container' => $container,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_topic', function (Blueprint $table) {
            $table->dropColumn([
                'width',
                'height',
                'container',
                'pos_x',
                'pos_y',
            ]);
        });
    }
}
