<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speciality_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('data')->nullable();
            $table->longText('ids')->nullable();
            $table->boolean('status')->default(1)->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы specialities
            $table->foreign('speciality_id')
                ->references('id')
                ->on('specialities')
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
        Schema::dropIfExists('results');
    }
}
