<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->unsignedBigInteger('parsing_id')->nullable();
            $table->string('href', 500);
            $table->string('code', 50)->nullable();
            $table->string('parent', 500)->nullable();
            $table->string('anchor', 500)->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы parsings
            $table->foreign('parsing_id')
                ->references('id')
                ->on('parsings')
                ->onDelete('cascade');
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
};
