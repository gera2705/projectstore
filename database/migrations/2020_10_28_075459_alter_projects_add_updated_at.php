<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsAddUpdatedAt extends Migration
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
            $table->timestamp('updated_at')->nullable();
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
            $table->dropTimestamps();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый'])->after('places');
        });
    }
}
