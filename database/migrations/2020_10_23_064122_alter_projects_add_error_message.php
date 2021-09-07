<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProjectsAddErrorMessage extends Migration
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
            $table->string('error_message')->nullable();
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


        if (Schema::hasColumn('projects', 'error_message')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('error_message');
            });
        }

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('state', ['Обработка', 'Открытый', 'Активный','Закрытый'])->after('places');
        });
    }
}
