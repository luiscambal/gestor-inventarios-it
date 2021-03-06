<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEquiposLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function __construct()
    {
        \Illuminate\Support\Facades\DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }

    public function up()
    {
        if (env('DB_MIGRACIONES', 'false') == 'false') {
            Schema::table('equipos_logs', function (Blueprint $table) {
                //
                $table->string('ip', 255)->nullable()->change();
                $table->string('codigo_barras', 255)->nullable()->change();
                $table->string('codigo_avianca', 255)->nullable()->change();
                $table->string('codigo_otro', 255)->nullable()->change();
                $table->integer('num_cajas')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipos_logs', function (Blueprint $table) {
            //
        });
    }
}
