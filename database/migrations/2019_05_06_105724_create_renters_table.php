<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renters', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('room_id');

            $table->string('f_name');
            $table->string('l_name');
            $table->string('p_address');
            $table->boolean('is_child');
            $table->string('phone_1');
            $table->string('phone_2')->nullable();
            $table->string('email');
            $table->string('photo')->nullable();
            $table->date('date_of_birth');
            $table->date('date_of_join');
            $table->integer('due_amount')->default(0);            

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
        Schema::dropIfExists('renters');
    }
}
