<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('street_id')->nullable();
            $table->string('guid', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('house_num', 255)->nullable();
            $table->string('build_num', 255)->nullable();
            $table->string('struc_num', 255)->nullable();
            $table->string('ao_guid', 255)->nullable();
            $table->unsignedBigInteger('house_id')->nullable();
            $table->string('full_number', 255)->nullable();
            $table->string('full_address')->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы streets
            $table->foreign('street_id')
                ->references('id')
                ->on('streets')
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
        Schema::dropIfExists('houses');
    }
}
