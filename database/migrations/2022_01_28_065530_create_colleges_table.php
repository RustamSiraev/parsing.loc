<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('full_title')->nullable();
            $table->integer('status')->default(1)->nullable();
            $table->unsignedBigInteger('director_id')->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('jur_name')->nullable();
            $table->string('ogrn', 255)->nullable();
            $table->string('inn', 255)->nullable();
            $table->string('kpp', 255)->nullable();
            $table->string('r_acc', 255)->nullable();
            $table->string('c_acc', 255)->nullable();
            $table->string('bank_name', 555)->nullable();
            $table->string('bank_bik', 255)->nullable();
            $table->string('okpo', 255)->nullable();
            $table->string('post_address')->nullable();
            $table->string('jur_address')->nullable();
            $table->string('ek_acc')->nullable();
            $table->string('k_acc')->nullable();
            $table->string('l_acc')->nullable();
            $table->string('bl_acc')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('total_places')->nullable();
            $table->integer('students_count')->nullable();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы users
            $table->foreign('director_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('colleges');
    }
}
