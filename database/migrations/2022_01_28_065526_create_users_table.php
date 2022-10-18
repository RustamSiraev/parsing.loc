<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->boolean('is_director')->nullable()->default(0);
            $table->integer('college_id')->nullable();
            $table->unsignedBigInteger('applicant_id')->nullable();
            $table->boolean('status')->default(1)->nullable();
            $table->integer('sign_in_count')->nullable();
            $table->timestamp('current_sign_in_at')->nullable();
            $table->timestamp('last_sign_in_at')->nullable();
            $table->string('current_sign_in_ip', 255)->nullable();
            $table->string('last_sign_in_ip', 255)->nullable();
            $table->string('cert', 255)->nullable();
            $table->string('gender')->nullable()->default(1);
            $table->timestamp('born_at')->nullable();
            $table->string('snils', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();

            // внешний ключ, ссылается на поле id таблицы roles
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('restrict');

            // внешний ключ, ссылается на поле id таблицы applicants
            $table->foreign('applicant_id')
                ->references('id')
                ->on('applicants')
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
        Schema::dropIfExists('users');
    }
}
