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
            // $table->string('category');
            $table->timestamps();
        });

        Schema::create('journal_entry_journal_tag', function (Blueprint $table) {
            $table->integer('journal_entry_id')->unsigned()->index();
            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('cascade');
            $table->integer('journal_tag_id')->unsigned()->index();
            $table->foreign('journal_tag_id')->references('id')->on('journal_tags')->onDelete('cascade');
            $table->primary(['journal_entry_id', 'journal_tag_id'], 'journal_entry_journal_tag_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entry_journal_tag');
        Schema::dropIfExists('journal_tags');
    }
}
