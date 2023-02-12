<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_tag', function (Blueprint $table) {
            $table->foreignId('book_id')->index();
            $table->foreignId('tag_id')->index();

            $table->foreign('book_id')->on('books')->references('id')->cascadeOnDelete();
            $table->foreign('tag_id')->on('tags')->references('id')->cascadeOnDelete();

            $table->primary(['book_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_tag');
    }
};
