<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntryJournalTranscriptionPagePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entry_journal_transcription_page', function (Blueprint $table) {
            $table->integer('journal_entry_id')->unsigned()->index('journal_entry_transcription_page_entry_id_index');
            $table->foreign('journal_entry_id', 'journal_entry_transcription_page_entry_id_foreign')->references('id')->on('journal_entries')->onDelete('cascade');
            $table->integer('journal_transcription_page_id')->unsigned()->index('journal_entry_transcription_page_page_id_index');
            $table->foreign('journal_transcription_page_id', 'journal_entry_transcription_page_page_id_foreign')->references('id')->on('journal_transcription_pages')->onDelete('cascade');
            $table->primary(['journal_entry_id', 'journal_transcription_page_id'], 'journal_entry_journal_transcription_page_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journal_entry_journal_transcription_page');
    }
}
