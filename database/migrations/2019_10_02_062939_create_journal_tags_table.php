<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_tags', function (Blueprint $table) {
            $table->integer('id')->unsigned()->primary();
            $table->string('subject')->unique();
            $table->timestamps();
        });

        Schema::create('journal_entry_journal_tag', function (Blueprint $table) {
            $table->integer('entry_id')->unsigned()->index();
            $table->foreign('entry_id')->references('id')->on('journal_entries')->onDelete('cascade');
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('journal_tags')->onDelete('cascade');
            $table->primary(['entry_id', 'tag_id']);
        });

        Schema::create('journal_tag_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('journal_tag_journal_tag_category', function (Blueprint $table) {
            $table->integer('tag_id')->unsigned()->index();
            $table->foreign('tag_id')->references('id')->on('journal_tags')->onDelete('cascade');
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('journal_tag_categories')->onDelete('cascade');
            $table->primary(['tag_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_tag_journal_tag_category');
        Schema::dropIfExists('journal_tag_categories');
        Schema::dropIfExists('journal_entry_journal_tag');
        Schema::dropIfExists('journal_tags');
    }
}
