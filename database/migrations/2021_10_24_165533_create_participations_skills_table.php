<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationsSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations_skills', function (Blueprint $table) {
            $table->primary(['id_skill', 'id_participation']);

            $table->unsignedBigInteger('id_skill');
            $table->unsignedBigInteger('id_participation');
            
            $table->foreign('id_skill')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('id_participation')->references('id')->on('participations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations_skills');
    }
}
