@extends('layout')

@section('title', 'Gestor documentos')

@section('content')

    <div class=" container pt-5 gestorBody">
        <div class="container text-center">
            <h1>Gestor de documentos</h1>
            <p class="tituloPrincipal">NORMATECA INTERNA DE EL COLEGIO DE LA FRONTERA NORTE</p>  
        </div> 

        <!-- Selectores de Indicadores de tipoDocumento -->
        <div class="container"> 
            <div class="row">   
                <div class="col-sm-2 tipoRecurso"> 
                    <a id="btnLineamientos" class="IndicadorTipo">  
                        <h3 class="tituloEfecto">Lineamientos</h3>
                        <p>Total de archivos almacenados</p>  
                        <i class="fa fa-database iconoBD Lineamientos" aria-hidden="true"> {{ $lineamientos->count() }}</i>
                        <hr>
                        <div><b>{{ $lineamientosPorcentaje }}%</b> Documentos vigentes <i class="fa fa-file" aria-hidden="true"></i></div>
                    </a> 
                </div> 
                <div class="col-sm-2 tipoRecurso"> 
                    <a id="btnManuales" class="IndicadorTipo">
                        <h3 class="tituloEfecto">Manuales</h3>
                        <p>Total de archivos almacenados</p> 
                        <i class="fa fa-database iconoBD Manuales" aria-hidden="true"> {{ $manuales->count() }}</i>
                        <hr>
                        <div><b>{{ $manualesPorcentajes }}%</b> Documentos vigentes <i class="fa fa-file" aria-hidden="true"></i></div> 
                    </a> 
                </div> 
                <div class="col-sm-2 tipoRecurso"> 
                    <a id="btnNormas" class="IndicadorTipo" data-tipoDocumento="3">
                        <h3 class="tituloEfecto">Normas</h3>
                        <p>Total de archivos almacenados</p> 
                        <i class="fa fa-database iconoBD Normas" aria-hidden="true"> {{ $normas->count() }}</i>
                        <hr>
                        <div><b>{{ $normasPorcentajes }}%</b> Documentos vigentes <i class="fa fa-file" aria-hidden="true"></i></div> 
                    </a> 
                </div> 
                <div class="col-sm-2 tipoRecurso"> 
                    <a id="btnProcedimientos" class="IndicadorTipo" data-tipoDocumento="4">
                        <h3 class="tituloEfecto">Procedimientos</h3>
                        <p>Total de archivos almacenados</p> 
                        <i class="fa fa-database iconoBD Procedimientos" aria-hidden="true"> {{ $procedimientos->count() }}</i>
                        <hr>
                        <div><b>{{ $procedimientosPorcentaje }}%</b> Documentos vigentes <i class="fa fa-file" aria-hidden="true"></i></div> 
                    </a>
                </div>  
            </div>
        </div>
 
        <div class="container"> 
            <br>
            <div class="d-grid">
                <button type="button" id="btnModal" name="btnModal" class="btn btn-secondary btn-block">Nuevo Registro</button>
                <br>
            </div>  
        </div> 

        <div class="container"> 
            <table id="tablaDocumentos" class="row-border hover" style="width:100%;">                 
                <thead>
                    <tr>
                        <th class="col-sm-5">Documento</th> 
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Área normativa</th> 
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Materia o tema</th>
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Fecha de emisión</th>
                        <th class="col-sm-1" data-toggle="tooltip" title="Agregar texto">Estatus</th> 
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th class="col-sm-5">Documento</th> 
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Área normativa</th> 
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Materia o tema</th>
                        <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Fecha de emisión</th>
                        <th class="col-sm-1" data-toggle="tooltip" title="Agregar texto">Estatus</th> 
                    </tr>
                </tfoot> 
            </table> 
        </div>  
    </div> 

    

    <!-- --- FORMULARIO CRUD DOCUMENTOS ---- -->
    <div class="modal fade" id="modalCRUD" name="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div>
                 
                <!-- <form id="formDocumentos" method="post" action="{{ url('/gestor/store') }}" enctype="multipart/form-data">  -->
                <form id="formDocumentos" method="POST" action="/gestor/store"  enctype="multipart/form-data">      
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                        <label for="documento" class="col-form-label">Documento:</label>
                        <input type="text" class="form-control" id="documento" name="documento">
                        </div>
                        <div class="form-group">
                        <label for="oficio" class="col-form-label">Oficio:</label>
                        <input type="text" class="form-control" id="oficio" name="oficio">
                        </div> 
                        <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion">
                        </div>                
                        <div class="form-group">
                        <label for="area" class="col-form-label">Área:</label>                
                        <select class="form-control" id="area" name="area">
                        <option value="#">Seleccionar </option>
                        <option value="1">Comité de Información</option>
                        <option value="2">Coordinación de Cómputo</option>    
                        <option value="3">Dirección de Recursos Humanos</option>  
                        <option value="4">Dirección de Recursos Materiales y Servicios</option>  
                        </select>
                        </div>    
                        <div class="form-group">
                        <label for="tipoDocumentoFk" class="col-form-label">Tipo de documento:</label>                
                        <select class="form-control" id="tipoDocumentoFk" name="tipoDocumentoFk">
                        <option value="#">Seleccionar</option>
                        <option value="1">Lineamientos</option>
                        <option value="2">Manuales</option>    
                        <option value="3">Normas</option>      
                        <option value="4">Procedimientos</option>      
                        </select>
                        </div>       
                        
                        <div class="form-group">
                        <label for="norma" class="col-form-label">Norma:</label>                
                        <select class="form-control" id="norma" name="norma">
                        <option value="1">Norma Interna</option>
                        <option value="2">Norma Administrativa</option>
                        <option value="3">Norma Sustantiva</option>         
                        </select>
                        </div>             

                        <div class="form-group">
                        <label for="materia" class="col-form-label">Materia:</label>                
                        <select class="form-control" id="materia" name="materia">
                        <option value="#">Seleccionar</option>
                        <option value="1">Adquisiciones</option>
                        <option value="2">Arrendamiento</option>
                        <option value="3">Obras publicas</option>
                        <option value="4">Recursos humanos</option>
                        <option value="5">Recursos Materiales</option>                       
                        </select>
                        </div>    

                        <div class="form-group">
                        <label for="fechaEmision" class="col-form-label">Fecha de emisión:</label>
                        <input type="date" class="form-control" id="fechaEmision" name="fechaEmision"> 
                        </div>      			
                        
                        <!-- Añadir las restricciones para este input -->
                        <div class="form-group">
                        <label for="archivo" class="col-form-label">Archivo:</label>
                        <input type="file" class="form-control" id="archivo"  name="archivo"> 
                        </div>     
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark" data-frm="nuevo">Guardar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>  





@endsection
	

@push('scripts')  

 


     
@endpush