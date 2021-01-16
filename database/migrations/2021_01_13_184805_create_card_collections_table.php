<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_collections', function (Blueprint $table) {

            $table->id();

            $table->foreignId('card_id')->constrained();

            $table->foreignId('collection_id')->constrained();

            $table->timestamps();
        });

        Schema::table('sales', function(Blueprint $table) {

            $table->foreignId('card_collection_id')->constrained();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('sales', function(Blueprint $table) {
            $table->dropForeign(['card_collection_id']);
            $table->dropColumn('card_collection_id');
        });

        Schema::dropIfExists('card_collections');
    }
}
