<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatesSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates_skills', function (Blueprint $table) {
            $table->primary(['id_skill', 'id_candidate']);

            $table->unsignedBigInteger('id_skill');
            $table->unsignedBigInteger('id_candidate');
            
            $table->foreign('id_skill')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('id_candidate')->references('id')->on('candidates')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidates_skills');
    }
}
