<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->integer('next_topic_id')->unsigned()->nullable()->index();
            $table->integer('previous_topic_id')->unsigned()->nullable()->index();

            $table->foreign('next_topic_id')->references('id')->on('topics');
            $table->foreign('previous_topic_id')->references('id')->on('topics');

            $table->string('next_topic_blurb')->nullable();
            $table->string('previous_topic_blurb')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn(['previous_topic_blurb', 'next_topic_blurb']);
            $table->dropForeign(['previous_topic_id']);
            $table->dropForeign(['next_topic_id']);
            $table->dropColumn(['previous_topic_id', 'next_topic_id']);
        });
    }
}
