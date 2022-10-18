<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('add_houses', function (Blueprint $table) {
            $table->id();
            $table->string('house', 50)->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы houses
            $table->foreign('house_id')
                ->references('id')
                ->on('houses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // внешний ключ, ссылается на поле id таблицы users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('add_houses');
    }
}
