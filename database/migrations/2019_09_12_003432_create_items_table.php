<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->enum('type', ['text', 'quotation', 'image', 'sound', 'video', 'comment'])->default('text');
            $table->text('text')->nullable();
            $table->string('source')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });

        Schema::create('topic_item', function (Blueprint $table) {
            $table->integer('topic_id');
            $table->integer('item_id');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('topic_item');
    }
}
