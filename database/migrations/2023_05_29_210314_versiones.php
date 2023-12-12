<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('versiones',function(Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre',250);  
            $table->integer('Version')->increments(); 
            $table->integer('DocumentoFk')->unsigned();
            $table->foreign('DocumentoFk')->references('id')->on('documentos');  
            $table->integer('EstatusFk')->unsigned();
            $table->foreign('EstatusFk')->references('id')->on('estatus');  
            $table->string('Ruta',250);  
            $table->boolean('Activo',true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('versiones');
    }
};
