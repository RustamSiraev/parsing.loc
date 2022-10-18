<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('l_name', 255)->nullable();
            $table->string('f_name', 255)->nullable();
            $table->string('m_name', 255)->nullable();
            $table->timestamp('born_at')->nullable();
            $table->string('born_place')->nullable();
            $table->string('gender')->nullable()->default(1);
            $table->string('citizenship')->nullable()->default(1);
            $table->string('doc_type', 255)->nullable();
            $table->string('doc_seria', 255)->nullable();
            $table->string('doc_number', 255)->nullable();
            $table->string('additional_contact', 255)->nullable();
            $table->timestamp('doc_date')->nullable();
            $table->string('doc_response')->nullable();
            $table->string('oms_policy', 255)->nullable();
            $table->string('snils', 255)->nullable();
            $table->string('flat', 255)->nullable();
            $table->string('fact_flat', 255)->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->integer('matches')->nullable()->default(1);
            $table->integer('house_id')->nullable();
            $table->integer('fact_house_id')->nullable();
            $table->integer('created_from')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants');
    }
}
