<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiplomasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diplomas', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_id')->nullable();
            $table->string('doc_series')->nullable();
            $table->string('doc_number')->nullable();
            $table->string('doc_issued')->nullable();
            $table->integer('doc_type')->nullable();
            $table->timestamp('doc_date')->nullable();
            $table->longText('data')->nullable();
            $table->string('average')->nullable();
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
        Schema::dropIfExists('diplomas');
    }
}
