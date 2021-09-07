<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsAddIsScanned extends Migration
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

        Schema::table('candidates', function (Blueprint $table) {
            $table->tinyInteger('is_scanned')->default(0);
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


        if (Schema::hasColumn('candidates', 'is_scanned')) {
            Schema::table('candidates', function (Blueprint $table) {
                $table->dropColumn('is_scanned'); // enum column
            });
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый'])->after('places');
        });

    }
}
