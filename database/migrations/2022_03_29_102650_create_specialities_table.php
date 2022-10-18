<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specialities', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255)->unique();
            $table->string('name', 255)->unique();
            $table->unsignedBigInteger('college_id')->nullable();
            $table->integer('education_level')->nullable()->default(1);
            $table->integer('education_form')->nullable()->default(1);
            $table->integer('budgetary')->nullable();
            $table->integer('commercial')->nullable();
            $table->integer('education_cost')->nullable();
            $table->integer('education_time')->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы colleges
            $table->foreign('college_id')
                ->references('id')
                ->on('colleges')
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
        Schema::dropIfExists('specialities');
    }
}
