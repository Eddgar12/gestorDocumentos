<?php

// namespace App\Http\Controllers;

use App\Models\DetalleView;
use App\Models\DocumentosView;
use App\Models\documentos;

use Illuminate\Http\Request;

// class gestorController extends Controller
class documentosConsulta
{
         
    public function documentos(int $opcion)
    { 
        // Filtro de documentos | seleccionado 
        $sqlDocumentos = documentos::select
        (
            'documentos.DocumentoID AS documentoID',
            'documentos.Nombre AS documento',
            'areas.Nombre AS area',
            'tiposDocumentos.Nombre AS tipoDocumento',
            'normas.Nombre AS norma',
            'tiposMaterias.Nombre AS tipoMateria', 
            'estatus.EstatusID AS estatusID' ,
            'estatus.Nombre AS estatus' ,
            'FechaEmision'
        )  
        ->leftJoin('areas','areas.AreaID','=','documentos.AreaFk')
        ->leftJoin('tiposDocumentos','tiposDocumentos.TipoDocumentoID','=','documentos.TipoDocumentoFk')
        ->leftJoin('normas','normas.NormaID','=','documentos.NormaFk') 
        ->leftJoin('tiposMaterias','tiposMaterias.tipoMateriaID','=','documentos.TipoMateriaFk')  
        ->leftJoin('estatus','estatus.EstatusID','=','documentos.EstatusFk')
        ->where('tiposDocumentos.TipoDocumentoID','=',2) 
        ->get(); 
        
        $misDatos = new DetalleView();

        foreach($sqlDocumentos  as $Docum ) 
        {           
            $registro = new DocumentosView();
            $registro->DocumentoID = $Docum['documentoID'];
            $registro->Documento = $Docum['documento'];
            $registro->Area = $Docum['area'];
            $registro->TipoDocumento = $Docum['tipoDocumento'];
            $registro->Norma = $Docum['norma'];
            $registro->TipoMateria = $Docum['tipoMateria'];
            $registro->EstatusID = $Docum['estatusID'];
            $registro->Estatus = $Docum['estatus'];
            $registro->FechaEmision = $Docum['FechaEmision']; 
        }   

        array_push($misDatos->data, $registro);
        return response()->json($misDatos, 200, []);  
    }



}

 



// @extends('layout')

// @section('content')

//     <div class=" container pt-5 gestorBody">
//         <div class="container text-center">
//             <h1>Gestor de documentos</h1>
//             <p class="tituloPrincipal">NORMATECA INTERNA DE EL COLEGIO DE LA FRONTERA NORTE</p>  
//         </div>

//         <!-- Selectores de Indicadores de tipoDocumento -->
//         <div class="container">
//             <div class="row"> 
//                 <form id="formDocumentos">
//                     <div class="form-group">
//                         <div class="col-sm-2 tipoRecurso"> 
//                             <a id="btnLineamientos" class="IndicadorTipo jsTipoDoc"> 
//                                 <h3 class="tituloEfecto">Lineamientos</h3>
//                                 <p>Total de archivos almacenados</p> 
//                                 <i class="fa fa-database iconoBD" aria-hidden="true"> {{ $lineamientosDoc->count() }}</i>
//                                 <hr>
//                                 <div><b>{{ $lineamientosActivos }}%</b> Documentos vigentes <i class="fa fa-file-o" aria-hidden="true"></i></div> 
//                             </a> 

//                             <!-- <button type="submit" id="btnLineamientos" class="IndicadorTipo" data-opcion="{{1}}"> 
//                                 <h3 class="tituloEfecto">Lineamientos</h3>
//                                 <p>Total de archivos almacenados</p> 
//                                 <i class="fa fa-database iconoBD" aria-hidden="true"> {{ $lineamientosDoc->count() }}</i>
//                                 <hr>
//                                 <div><b>{{ $lineamientosActivos }}%</b> Documentos vigentes <i class="fa fa-file-o" aria-hidden="true"></i></div> 
//                             </button> -->



//                         </div>
//                     </div>

//                     <div class="form-group">
//                         <div class="col-sm-2 tipoRecurso"> 
//                             <a href="" id="btnManuales" class="IndicadorTipo jsTipoDoc" action="{{ url('gestor/2')}}" method="post">
//                                 <h3 class="tituloEfecto">Manuales</h3>
//                                 <p>Total de archivos almacenados</p> 
//                                 <i class="fa fa-database iconoBD2" aria-hidden="true"> {{ $manualesDoc->count() }}</i>
//                                 <hr>
//                                 <div><b>{{ $manualesActivos }}%</b> Documentos Activos <i class="fa fa-file" aria-hidden="true"></i></div> 
//                             </a> 
//                         </div>
//                     </div>

//                     <div class="form-group">
//                         <div class="col-sm-2 tipoRecurso"> 
//                             <a href="" id="btnNormas" class="IndicadorTipo jsTipoDoc" data-tipoDocumento="3">
//                                 <h3 class="tituloEfecto">Normas</h3>
//                                 <p>Total de archivos almacenados</p> 
//                                 <i class="fa fa-database iconoBD" aria-hidden="true"> {{ $normassDoc->count() }}</i>
//                                 <hr>
//                                 <div><b>{{ $normasActivos }}%</b> Documentos Activos <i class="fa fa-file" aria-hidden="true"></i></div> 
//                             </a> 
//                         </div>
//                     </div>

//                     <div class="form-group">
//                         <div class="col-sm-2 tipoRecurso"> 
//                             <a href="" id="btnProcedimientos" class="IndicadorTipo jsTipoDoc" data-tipoDocumento="4">
//                                 <h3 class="tituloEfecto">Procedimientos</h3>
//                                 <p>Total de archivos almacenados</p> 
//                                 <i class="fa fa-database iconoBD" aria-hidden="true"> {{ $procedimientosDoc->count() }}</i>
//                                 <hr>
//                                 <div><b>{{ $procedimientosActivos }}%</b> Documentos Activos <i class="fa fa-file" aria-hidden="true"></i></div> 
//                             </a>
//                         </div>
//                     </div>

//                 </form>
              
//             </div>
//         </div>

//         <div class="container">
//             <div class="tipoNorma">
//                 <p>Norma interna:</p>
//                 <div class="tipoDocumento">  
//                     <input id="docAdministrativas" type="radio" name="type" value="Administrativas">
//                     <label for="docAdministrativas">Administrativas</label>
//                 </div>
//                 <div class="tipoDocumento">  
//                     <input id="docsustantivas" type="radio" name="type" value="Sustantivas">
//                     <label for="docsustantivas">Sustantivas</label> 
//                 </div>
//             </div>
//         </div>


//         <div class="container"> 
//             <table id="tablaDocumentos" class="row-border hover" style="width:100%;">                 
//                 <thead>
//                     <tr>
//                         <th class="col-sm-5">Documento</th> 
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Área normativa</th> 
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Materia o tema</th>
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Fecha de emisión</th>
//                         <th class="col-sm-1" data-toggle="tooltip" title="Agregar texto">Estatus</th> 
//                     </tr>
//                 </thead>
//                 <tbody>
                    
//                 </tbody>
//                 <tfoot>
//                     <tr>
//                         <th class="col-sm-5">Documento</th> 
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Área normativa</th> 
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Materia o tema</th>
//                         <th class="col-sm-2" data-toggle="tooltip" title="Agregar texto">Fecha de emisión</th>
//                         <th class="col-sm-1" data-toggle="tooltip" title="Agregar texto">Estatus</th> 
//                     </tr>
//                 </tfoot> 
//             </table> 
//         </div> 
    
    
//     </div> 

// @endsection
	

// @push('scripts')  

//     <!---- Recuperar registros con Ajax ---->
//     <!-- <script>
//         $(document).ready(function(){ 
                
       

//             $('#tablaDocumentos').DataTable({
//                 // "order": [
//                 //     [1, "asc"]
//                 // ],
//                 "language": {
//                     "lengthMenu": "Mostrando _MENU_ registros por página",
//                     "zeroRecords": "No se encontraron resultados",
//                     "info": "Mostrando _PAGE_ de _PAGES_",

//                     "infoEmpty": "Proyectos",
//                     "infoFiltered": "(Filtro de _MAX_ registros)",
//                     "search": "Búsqueda :",
//                     "paginate": {
//                         "previous": "Anterior",
//                         "next": "Siguiente"
//                     }
//                 },


//                 ajax: '../gestor/registros', 
//                 columns: [  
//                     // {data: 'Documento', "render": function ( data, type, row, meta ) 
//                     //     {
//                     //     // return '<a href="'+data+'"> '+data+' </a>'; 
//                     //         return '<i class="fa fa-folder" aria-hidden="true"></i>' +data+' <p class="tipoCoordinacion"><b>Tipo de Norma: </b> '+data+' ';
//                     //     }
//                     // },  
//                     {data: 'Documento', "render": function ( data, type, row, meta ) 
//                         { 
//                             return '<i class="fa fa-folder" aria-hidden="true"></i> ' +data+' <p class="tipoCoordinacion"><b>Tipo de Norma: </b> '+ row.Norma +'  ';
//                         }
//                     },
//                     {data: 'Area'},
//                     {data: 'TipoMateria'}, 
//                     {data: 'FechaEmision'},  
//                     {data: 'EstatusID',
//                         "render":function(data, type,row)
//                         {
//                             if(data == 1)  {  
//                                 return '<span class="statusActivo"> <i class="fa fa-circle-thin iconoActivo" aria-hidden="true"></i> ' +row.Estatus+ '</span> '
//                             }        
//                             if(data == 2) 
//                             {
//                                 return '<span class="statusInactivo"> <i class="fa fa-circle-thin iconoInactivo" aria-hidden="true"></i> ' +row.Estatus+ '</span> ' 
//                             }      
//                         }
//                     } 
                  
                   
                     
//                 ], 
//             });
//         });
//     </script> -->



//     <!-- <script>
//         $(document).ready(function(){
//         $('[data-toggle="tooltip"]').tooltip();   
//         }); 
// 	</script> -->

//     <!-- 
//         Generar script para refrescar tabla de Documentos 
//         ::se filtra con onclick TipoDocumento
//     -->

//     <!-- <script>
//         $(document).ready(function(){
//             $('.jsTipoDoc').click(function(e){
//                 $actionURL= $('#')
                

//             });
        
//         }); 
// 	</script>
//      -->
    



     
// @endpush