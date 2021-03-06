<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn(['written_at_raw', 'weather_raw', 'content_raw']);
        });

        Schema::table('journal_entries', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->string('weather')->change();

            $table->text('raw')->nullable();
            $table->text('excerpt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('journal_entries', function (Blueprint $table) {
            $table->dropColumn(['excerpt', 'raw']);

            $table->text('weather')->change();
            $table->bigIncrements('id')->change();

            $table->text('written_at_raw');
            $table->text('weather_raw')->nullable();
            $table->text('content_raw');
        });
    }
}
