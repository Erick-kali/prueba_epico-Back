<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombres', 100);
            $table->string('apellidos', 100);
            $table->string('email', 100)->unique();
            $table->string('contrasena', 255);
            $table->unsignedBigInteger('id_rol'); // Clave foránea a la tabla 'rol'
            $table->integer('numero_intento')->nullable();
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('id_rol')->references('id_rol')->on('rol')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
