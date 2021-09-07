<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->integer('places');
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый']);
            $table->unsignedBiginteger('user_id'); // supervisor_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBiginteger('type_id'); // type_id
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->string('goal');
            $table->string('idea');
            $table->date('date_start');
            $table->date('date_end');
            $table->string('requirements');
            $table->string('customer');
            $table->string('expected_result');
            $table->string('additional_inf')->nullable();
            $table->string('result')->nullable();
        });
    }
//
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
