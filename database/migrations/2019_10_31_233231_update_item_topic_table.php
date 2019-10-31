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
