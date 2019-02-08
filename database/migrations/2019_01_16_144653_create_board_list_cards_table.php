<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardListCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_list_cards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id');
            $table->string('board_id');
            $table->string('board_list_id'); 
            $table->string('item_type');
            $table->string('item_src');
            $table->string('item_add_by'); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board_list_cards');
    }
}
