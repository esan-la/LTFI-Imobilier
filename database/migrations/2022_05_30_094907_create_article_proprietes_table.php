<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleProprietesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_proprietes', function (Blueprint $table) {
            $table->foreignId('article_id')->constrained();
            $table->foreignId('propriete_article_id')->constrained();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('article_proprietes', function(Blueprint $table){
            $table->dropForeign(['article_id', 'propriete_article_id']);
        });
        Schema::dropIfExists('article_proprietes');
    }
}
