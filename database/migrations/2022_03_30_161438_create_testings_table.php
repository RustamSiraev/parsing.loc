<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('speciality_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('grade')->nullable()->default(1);
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы specialities
            $table->foreign('speciality_id')
                ->references('id')
                ->on('specialities')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('testings');
    }
}
