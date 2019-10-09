<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOtherFieldsToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('iip_path')->nullable();
            $table->string('year')->nullable();
        });

        DB::statement("ALTER TABLE items CHANGE COLUMN type type ENUM('text', 'quotation', 'image', 'sound', 'video', 'comment', 'author_text', 'slogan') NOT NULL DEFAULT 'text'"); // https://laravel.com/docs/migrations#modifying-columns ENUM column type is not supported for ->change()
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['iip_path', 'year']);
        });

        DB::statement("ALTER TABLE items CHANGE COLUMN type type ENUM('text', 'quotation', 'image', 'sound', 'video', 'comment') NOT NULL DEFAULT 'text'");
    }
}
