<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('

        CREATE TRIGGER `entrada_salida_funcionario`     
        BEFORE UPDATE 
        ON `funcionario` 
        FOR EACH ROW
        if old.estadoFuncionario != new.estadoFuncionario
        THEN
            INSERT INTO registro_funcionario (funcionario, nuevoEstado, fecha, hora)
            VALUES (OLD.id, NEW.estadoFuncionario, CURDATE(), 	CURTIME()); 
        END if;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `entrada_salida_funcionario`');
    }
};
