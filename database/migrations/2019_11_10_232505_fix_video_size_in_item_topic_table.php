<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixVideoSizeInItemTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_topic', function (Blueprint $table) {
            $topics = \App\Models\Topic::all();
            foreach ($topics as $topic) {
                foreach ($topic->items as $item) {
                    if ($item->type == 'video') {
                        $item->pivot->setDefaultSizeAndPosition(null, $item->video->width, $item->video->height);
                        $item->pivot->save();
                    }
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_topic', function (Blueprint $table) {
            //
        });
    }
}
