<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statements', function (Blueprint $table) {
            $table->id();
            $table->integer('created_from')->nullable()->default(1);
            $table->unsignedBigInteger('user_id')->nullable()->default(0);
            $table->unsignedBigInteger('status_id')->nullable()->default(1);
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->unsignedBigInteger('speciality_id')->nullable();
            $table->boolean('first')->default(1)->nullable();
            $table->boolean('target')->default(0)->nullable();
            $table->boolean('benefit')->default(0)->nullable();
            $table->boolean('limited')->default(0)->nullable();
            $table->boolean('disabled')->default(0)->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamp('going_at')->nullable();
            $table->timestamp('refused_at')->nullable();
            $table->string('message', 555)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы statement_statuses
            $table->foreign('status_id')
                ->references('id')
                ->on('statement_statuses')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // внешний ключ, ссылается на поле id таблицы applicants
            $table->foreign('applicant_id')
                ->references('id')
                ->on('applicants')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // внешний ключ, ссылается на поле id таблицы users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            // внешний ключ, ссылается на поле id таблицы specialities
            $table->foreign('speciality_id')
                ->references('id')
                ->on('specialities')
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
        Schema::dropIfExists('statements');
    }
}
