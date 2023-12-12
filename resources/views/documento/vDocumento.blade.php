@extends('layout')

@section('content')

    <div class=" container pt-5 gestorBody">
        <div class="container text-center">
            <h1>Gestor de documentos</h1>
            <p class="tituloPrincipal">NORMATECA INTERNA DE EL COLEGIO DE LA FRONTERA NORTE</p>  
        </div>

        <!-- vista principal: Datos del registro, version ACTUAL -->  
        <br><br>
        <div class="container vistaDoc">  
            <h3 style="color:#7893ac;">{{$doc->Documento}}</h3>
            <p><b>Número de oficio: </b>{{$doc->Oficio}}</p>   
            <p><b>Estatus: </b>{{$doc->Estatus}}</p>  
            <p><b>Fecha de emisión: </b>{{$doc->FechaEmision}}</p>
            <p><b>Fecha de última actualización:  </b>N/A </p>
            <button type="button" id="btnEditar" data-frm="editar" name="btnEditar" class="btn btn-secondary">Editar Registro</button> 
            <a href="/documento/delete/{{$doc->DocumentoID}}" id="btnEliminar" class="btn btn-secondary">Eliminar Registro</a>

            <a href="/documento/download/{{$doc->DocumentoID}}/{{$doc->VersionFk}}/2" id="btnDescargar" class="btn btn-secondary" target="_blank">Descargar Documento</a>
            <button type="button" id="btnVersiones" name="btnVersiones" class="btn btn-secondary">Versiones</button>
            <a href="/gestor" id="btnDescargar" class="btn btn-light btnInicio">Inicio</a>
            <br>
            <!-- href="/documento/download/{{$doc->DocumentoID}}/DocumentoID/VersionID/1"     Ruta para la version actual    -->
            <a href="/documento/download/{{$doc->DocumentoID}}/{{$doc->VersionFk}}/1" target="_blank">Vista completa</a>  
                <iframe src="/documento/download/{{$doc->DocumentoID}}/{{$doc->VersionFk}}/1" name="{{$doc->Documento}}" height="900px" width="100%" title="{{$doc->Documento}}"></iframe>
            <p><b>Descripción: </b> {{$doc->Descripcion}}</p> 
            <p><b>Area: </b> {{$doc->Area}}</p> 
        </div>
        <br> 
    </div>

    <!-- --- FORMULARIO CRUD DOCUMENTOS ---- --> 
    <div class="modal fade" id="modalCRUD" name="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div> 
                 
                <form id="formDocumento" action="/documento/update" method="POST" enctype="multipart/form-data">     
                    @csrf
                    <div class="modal-body">  
                        <input id="documentoID" name="documentoID" type="hidden" value="{{$doc->DocumentoID}}">
                     
                        <div class="form-group">
                        <label for="nombre" class="col-form-label">Documento:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{$doc->Documento}}">
                        </div>
                        <div class="form-group">
                        <label for="oficio" class="col-form-label">Oficio:</label>
                        <input type="text" class="form-control" id="oficio" name="oficio" value="{{$doc->Oficio}}">
                        </div> 
                        <div class="form-group">
                        <label for="descripcion" class="col-form-label">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion"  value="{{$doc->Descripcion}}">
                        </div>                
                        <div class="form-group">
                        <label for="areaFk" class="col-form-label">Área:</label>                
                        <select class="form-control" id="areaFk" name="areaFk">
                        <option value="{{$doc->AreaFk}}"> {{$doc->Area}} </option>
                        <option value="1">Comité de Información</option>
                        <option value="2">Coordinación de Cómputo</option>    
                        <option value="3">Dirección de Recursos Humanos</option>  
                        <option value="4">Dirección de Recursos Materiales y Servicios</option>  
                        </select>
                        </div>    
                        <div class="form-group">
                        <label for="tipoDocumentoFk" class="col-form-label">Tipo de documento:</label>                
                        <select class="form-control" id="tipoDocumentoFk" name="tipoDocumentoFk">
                        <option value="{{$doc->TipoDocumentoFk}}">{{$doc->TipoDocumento}}</option>
                        <option value="1">Lineamientos</option>
                        <option value="2">Manuales</option>    
                        <option value="3">Normas</option>      
                        <option value="4">Procedimientos</option>      
                        </select>
                        </div>       
                        
                        <div class="form-group">
                        <label for="normaFk" class="col-form-label">Norma:</label>                
                        <select class="form-control" id="normaFk" name="normaFk">
                        <option value="{{$doc->NormaFk}}">{{$doc->Norma}}</option>
                        <option value="2">Norma Administrativa</option>
                        <option value="3">Norma Sustantiva</option>         
                        </select>
                        </div>             

                        <div class="form-group">
                        <label for="tipoMateriaFk" class="col-form-label">Materia:</label>                
                        <select class="form-control" id="tipoMateriaFk" name="tipoMateriaFk">
                        <option value="{{$doc->TipoMateriaFk}}">{{$doc->TipoMateria}}</option>
                        <option value="1">Adquisiciones</option>
                        <option value="2">Arrendamiento</option>
                        <option value="3">Obras publicas</option>
                        <option value="4">Recursos humanos</option>
                        <option value="5">Recursos Materiales</option>                       
                        </select>
                        </div>    

                        <div class="form-group">
                        <label for="FechaEmision" class="col-form-label">Fecha de emisión:</label>
                        <input type="date" class="form-control" id="FechaEmision" name="FechaEmision" value="{{$doc->FechaEmision}}"> 
                        <!-- <input type="date" class="form-control" id="FechaEmision" name="FechaEmision" value="{{$doc->FechaEmision}}">  -->
                        </div> 

                        <div class="form-group">
                        <label for="estatusFk" class="col-form-label">Estatus:</label>                
                        <select class="form-control" id="estatusFk" name="estatusFk">
                        <option value="{{$doc->EstatusFk}}">{{$doc->Estatus}}</option>
                        <option value="1">vigente</option>
                        <option value="2">Derogado</option>                     
                        </select>
                        </div> 

                        <br>
                        <p class="tituloDocumento">Actualizar este archivo: <i class='far fa-file-alt'></i></p>
                        <input type="radio" id="VersionActual" name="fav_language" value="VersionActual">
                        <label for="VersionActual">Manetener versión actual</label><br>
                        <input type="radio" id="NuevaVersion" name="fav_language" value="NuevaVersion">
                        <label for="NuevaVersion">Nueva versión</label> 
                        <br>

                        <div class="form-group DivArchivo">
                        <label for="archivo" class="col-form-label"><b>Importar nuevo archivo </b><i class='fas fa-file-import'></i></label>
                        <input type="file" class="form-control" id="archivo"  name="archivo">  
                        </div>   
                        
                    </div>
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="btnGuardar" class="btn btn-dark" data-frm="editar">Guardar</button>
                    </div>
                </form>    
            </div>
        </div>
    </div>  

    <!-- --- VISTA DE VERSIONES DEL DOCUMENTO ---- -->   
    <div class="modal" id="versionDocumento" name="versionDocumento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
                </div>  
                <div class="modal-body">   
                    <table id="tblVersiones" class="table" style="width:100%">
                        <thead>
                            <tr> 
                                <th>Version</th>
                                <th>Estatus</th>
                                <th>Fecha</th> 
                            </tr>
                        </thead>
                        <tbody>  
                        @foreach ($DocVersiones->versiones as $v) 
                            <tr> 
                         
                                <td><a href="/documento/download/{{$v->DocumentoFk}}/{{$v->VersionID}}/1" target="_blank">{{ $v->Numero }} - {{ $v->Oficio }}</a></td>
                                <td>{{$v->Estatus}}</td>
                                <td>{{$v->FechaEmision}}</td>  
                            </tr> 
                        @endforeach
                        </tbody>
                    </table> 
                </div>
                <div class="modal-footer"> 
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button> 
                </div>
                    
            </div>
        </div>
    </div> 


	 



@endsection
	

@push('scripts') 
	 

    <!-- <script>
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
        }); 
	</script> -->

     


     
@endpush