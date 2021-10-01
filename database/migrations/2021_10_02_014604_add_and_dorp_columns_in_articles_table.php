<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndDorpColumnsInArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('selected_article');
            $table->string('feature_post_selected')->nullable()->after('category');
            $table->string('editors_pick_selected')->nullable()->after('feature_post_selected');
            $table->string('trending_selected')->nullable()->after('editors_pick_selected');
            $table->string('event_selected')->nullable()->after('trending_selected');
            $table->string('category_post_selected')->nullable()->after('event_selected');
           
            $table->string('feature_post')->nullable()->after('category_post_selected');
            $table->string('slide_show')->nullable()->after('feature_post');
            $table->string('editors_pick')->nullable()->after('slide_show');
            $table->string('trending')->nullable()->after('editors_pick');
            $table->string('event')->nullable()->after('trending');
            $table->string('category_post')->nullable()->after('event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            //
        });
    }
}
