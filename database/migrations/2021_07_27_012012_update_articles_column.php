<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateArticlesColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('judul')->nullable()->change();
            $table->string('slug')->nullable()->change();
            $table->string('gambar')->nullable()->change();
            $table->text('konten')->nullable()->change();
            $table->string('tag')->nullable()->change();
            $table->unsignedBigInteger('category')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
