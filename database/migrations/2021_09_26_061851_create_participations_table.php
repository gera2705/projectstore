<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participations', function (Blueprint $table) {
            $table->primary(['id_project', 'id_candidate', 'id_state']);

            $table->unsignedBigInteger('id_project');
            $table->unsignedBigInteger('id_candidate');
            $table->unsignedBigInteger('id_state');
            
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('id_candidate')->references('id')->on('candidates')->onDelete('cascade');
            $table->foreign('id_state')->references('id')->on('state_participations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participations');
    }
}
