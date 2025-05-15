<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rol', function (Blueprint $table) {
            $table->id('id_rol');  // Clave primaria (unsignedBigInteger por defecto)
            $table->string('nombre_rol', 100);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rol');
    }
};
