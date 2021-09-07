<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('state'); // enum column
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->text('goal')->change();
            $table->text('idea')->change();
            $table->text('expected_result')->change();
            $table->text('additional_inf')->change();
            $table->text('result')->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый'])->after('places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('state'); // enum column
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('goal')->change();
            $table->string('idea')->change();
            $table->string('expected_result')->change();
            $table->string('additional_inf')->change();
            $table->string('result')->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый'])->after('places');
        });
    }
}
