<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('street_id')->nullable();
            $table->string('house', 255)->nullable(1);
            $table->string('guid', 255)->nullable();
            $table->string('parent_guid', 255)->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы streets
            $table->foreign('street_id')
                ->references('id')
                ->on('streets')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
