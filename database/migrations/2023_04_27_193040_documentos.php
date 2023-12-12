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
        Schema::create('documentos',function(Blueprint $table) {
            $table->increments('id'); 
            $table->string('Oficio',45)->nullable();
            $table->boolean('Activo',true);
            $table->string('Descripcion',250)->nullable();

            $table->integer('AreaFk')->unsigned();
            $table->foreign('AreaFk')->references('id')->on('areas');
            $table->integer('TipoDocumentoFk')->unsigned();
            $table->foreign('TipoDocumentoFk')->references('id')->on('tiposDocumentos');
            $table->integer('NormaFk')->unsigned();
            $table->foreign('NormaFk')->references('id')->on('normas'); 

            $table->integer('TipoMateriaFk')->unsigned();
            $table->foreign('TipoMateriaFk')->references('id')->on('tiposMaterias'); 
            $table->integer('EstatusFk')->unsigned();
            $table->foreign('EstatusFk')->references('id')->on('estatus');  
            $table->timestamp('FechaEmision')->nullable();  

            $table->integer('RegistroUsuarioFk')->unsigned()->nullable();
            // $table->foreign('RegistroUsuarioFk')->references('UsuarioID')->on('usuarios');
            $table->string('RegistroMotivo',250)->nullable();
            $table->integer('ModificoUsuarioFk')->unsigned()->nullable();
            // $table->foreign('ModificoUsuarioFk')->references('UsuarioID')->on('usuarios');  
            $table->string('ModificoMotivo',250)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
