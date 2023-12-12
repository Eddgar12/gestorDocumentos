<?php

namespace App\Http\Controllers;

use App\Models\DetalleView;
use App\Models\DocumentosView;
use App\Models\documentos;
use App\Models\versiones;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class gestorController extends Controller
{
    /* ------------------Muestra todos los Documento  -------------------*/
    public function index()
    {    
        /** MODULOS -------------------------------- Descripcion de cada tipo de datos ------------------------------- */  
        $lineamientos = documentos::all()->where('TipoDocumentoFk', '1')->where('Activo', '1');
        $lineamientosActivos = documentos::all()->where('TipoDocumentoFk', '1')->where('EstatusFk', '1')->where('Activo', '=', 1); 

        $manuales = documentos::all()->where('TipoDocumentoFk', '2')->where('Activo', '1');
        $manualesActivos = documentos::all()->where('TipoDocumentoFk', '2')->where('EstatusFk', '1')->where('Activo', '=', 1);

        $normas = documentos::all()->where('TipoDocumentoFk', '3')->where('Activo', '1');
        $normasActivos = documentos::all()->where('TipoDocumentoFk', '3')->where('EstatusFk', '1')->where('Activo', '=', 1);

        $procedimientos = documentos::all()->where('TipoDocumentoFk', '4')->where('Activo', '1');
        $procedimientosActivos = documentos::all()->where('TipoDocumentoFk', '4')->where('EstatusFk', '1')->where('Activo', '=', 1);

        // Traer los porcentajes de los tipos de documentos activos ------------------ VISTA DE PORCENTAJES ACTIVOS ------------------- */ 
        //  Lineamientos
        $lineamientosPorcentaje = ($lineamientos->count() != 0) ?
            round(($lineamientosActivos->count() * 100) / $lineamientos->count(), 2) : 'NA';
        //  Manuales
        $manualesPorcentajes = ($normas->count() != 0) ?
            round(($manualesActivos->count() * 100) / $manuales->count(), 2) : 'NA';
        //  Normas 
        $normasPorcentajes = ($normas->count() != 0) ?
            round(($normasActivos->count() * 100) / $normas->count(), 2) : 'NA';
        //  Procedimientos 
        $procedimientosPorcentaje = ($procedimientos->count() != 0) ?
            round(($procedimientosActivos->count() * 100) / $procedimientos->count(), 2) : 'NA';
 
            
        return view('principal.gestor', compact('lineamientos','manuales','normas','procedimientos','lineamientosPorcentaje','manualesPorcentajes','normasPorcentajes','procedimientosPorcentaje'));
    }



    // FUNCION PARA RECUPERAR LOS REGISTROS    -+-------------------------------------- DOCUMENTOS -------------------------------------------------- 
    public function show($opcion) 
    {
        //  //https://es.stackoverflow.com/questions/98805/badmethodcallexception-method-show-does-not-exist-laravel   
        //Consulta segun el tipo de documento
        $sqlDocumentos = $this->consultarDocumentos($opcion);

        //Creamos funcion para crear los registros apartir de la consulta
        $misDatos = $this->crearRegistros($sqlDocumentos);

        //Devolvemos la respuesta JSON
        return response()->json($misDatos, 200, []);
    }

    private function consultarDocumentos($tipoDocumento) {
        $tiposDocumentos = [
            'Lineamientos' => 1,
            'Manuales' => 2,
            'Normas' => 3,
            'Procedimientos' => 4
        ];
            
        //Verificamos si el tipo de documento es válido
        if (array_key_exists($tipoDocumento, $tiposDocumentos)) {
        
            //Obtenemos el id del tipo de documento
            $tipo = $tiposDocumentos[$tipoDocumento];
            
            //Hacemos la consulta común a todos los tipos de documentos
            // $sqlDocumentos = documentos::select(
            //     'documentos.id AS documentoID',
            //     'versiones.Nombre AS documento',
            //     'MAX(versiones.Version) AS version',
            //     'areas.Nombre AS area',
            //     'tiposDocumentos.Nombre AS tipoDocumento',
            //     'normas.Nombre AS norma',
            //     'tiposMaterias.Nombre AS tipoMateria',
            //     'documentos.EstatusFk AS estatusFk' ,
            //     'estatus.Nombre AS estatus' ,
            //     'versiones.Ruta AS ruta',
            //     'FechaEmision')
                
            //     ->leftJoin('versiones','versiones.DocumentoFk','=','documentos.id')
            //     ->leftJoin('areas','areas.id','=','documentos.AreaFk')
            //     ->leftJoin('tiposDocumentos','tiposDocumentos.id','=','documentos.TipoDocumentoFk')
            //     ->leftJoin('normas','normas.id','=','documentos.NormaFk')
            //     ->leftJoin('tiposMaterias','tiposMaterias.id','=','documentos.TipoMateriaFk') 
            //     ->leftJoin('estatus','estatus.id','=','documentos.EstatusFk')

            //     ->where('documentos.Activo', '=', 1)
            //     ->where('versiones.Activo', '=', 1)
            //     ->where('tiposDocumentos.id','=', $tipo)  
            //     ->groupBy('documentoID')
            
                
            // ->get();

            $sqlDocumentos = versiones::select(
                'versiones.id as versionesID', 
                'versiones.DocumentoFk AS documentoID',
                'versiones.Nombre AS documento',
              
                'areas.Nombre AS area',
                'tiposDocumentos.Nombre AS tipoDocumento',
                'normas.Nombre AS norma',
                'tiposMaterias.Nombre AS tipoMateria',
                'documentos.EstatusFk AS estatusFk' ,
                'estatus.Nombre AS estatus' ,
                'versiones.Ruta AS ruta',
                'FechaEmision')
                
                ->leftJoin('documentos','documentos.id','=','versiones.DocumentoFk')
                ->leftJoin('areas','areas.id','=','documentos.AreaFk')
                ->leftJoin('tiposDocumentos','tiposDocumentos.id','=','documentos.TipoDocumentoFk')
                ->leftJoin('normas','normas.id','=','documentos.NormaFk')
                ->leftJoin('tiposMaterias','tiposMaterias.id','=','documentos.TipoMateriaFk') 
                ->leftJoin('estatus','estatus.id','=','documentos.EstatusFk')

                ->where('documentos.Activo', '=', 1)
                ->where('versiones.Activo', '=', 1)
                ->where('versiones.EstatusFk', '=', 1)
                ->where('tiposDocumentos.id','=', $tipo)  
               
            
                
            ->get();
             
            return $sqlDocumentos;
        }
           
    }
 
    private function crearRegistros($sqlDocumentos) {

        //Creamos un objeto DetalleView para almacenar los registros
        $misDatos = new DetalleView();
        
        //Recorremos la consulta y creamos los registros
        foreach($sqlDocumentos  as $Docum )
        {
        
            $registro = new DocumentosView();
            $registro->DocumentoID = $Docum['documentoID'];
            $registro->Documento = $Docum['documento'];
            $registro->Area = $Docum['area'];
            $registro->TipoDocumento = $Docum['tipoDocumento'];
            $registro->Norma = $Docum['norma'];
            $registro->TipoMateria = $Docum['tipoMateria'];
            $registro->EstatusFk = $Docum['estatusFk'];
            $registro->Estatus = $Docum['estatus'];
            $registro->Ruta = $Docum['ruta'];
            $aux = $Docum['FechaEmision'];
            $registro->FechaEmision  = date("d-m-Y", strtotime($aux));
            
            array_push($misDatos->data, $registro);
        }
        
        //Devolvemos el objeto DetalleView
        return $misDatos;
    }
   
    /** ----------------------- -ajax-crud ------------------- */ 
    public function store(Request $request) {
        // print_r($request->all());  
 

        if ($request->file('archivo')->isValid()) { 

            $this->validate($request,[
                'documento'=> 'required',
                'oficio'=> 'required',
                'descripcion'=> 'required',
                'area'=> 'required',
                'tipoDocumentoFk'=> 'required',
                'norma'=> 'required',
                'materia'=> 'required',
                'archivo'=> 'required', 
                'fechaEmision'=> 'required', 
    
            ]);
    
            $data = new documentos;
            
            $data->Oficio = $request->input('oficio');
            $data->Activo = 1;
            $data->Descripcion = $request->input('descripcion');
            $data->AreaFk = $request->input('area');
            $data->TipoDocumentoFk = $request->input('tipoDocumentoFk');
            $data->NormaFk = $request->input('norma');
            $data->TipoMateriaFk = $request->input('materia');
            $data->EstatusFk = 1;
            $data->FechaEmision = $request->input('fechaEmision');
            
            /**Guardar registros de archivos AWS S3  Bucket */ 
            $content = $request->file('archivo'); 
            $tipo = $data->TipoDocumentoFk;
                    
            if($data->save()){
                 
                switch($tipo)
                {
                    case 1:
                        $documento_Path = Storage::disk('s3')->put('Lineamientos/'.$data->Nombre,$content); 
                    break;
                    case 2:
                        $documento_Path = Storage::disk('s3')->put('Manuales/'.$data->Nombre,$content); 
                    break;
                    case 3:
                        $documento_Path = Storage::disk('s3')->put('Normas/'.$data->Nombre,$content); 
                    break;
                    case 4:
                        $documento_Path = Storage::disk('s3')->put('Procedimientos/'.$data->Nombre,$content); 
                    break; 
                } 
                $DocumentoVersion = new versiones();   
                $DocumentoVersion->Nombre = $request->input('documento');      
                $DocumentoVersion->Version = 1; 
                $DocumentoVersion->DocumentoFk = $data->id;
                $DocumentoVersion->Ruta = $documento_Path; 
                $DocumentoVersion->Activo = 1;
                $DocumentoVersion->EstatusFk = 1; 
                $DocumentoVersion->save();
    
            }
        }
        
            
        if($data->save() == true and $DocumentoVersion->save() == true) {
            // return redirect('gestor')->with('success','Dato guardado!'); 
            // return back()->with(['json' => ['message' => 'Datos guardados correctamente']]);
            // return redirect('gestor')->with(['json' => ['message' => 'Datos guardados correctamente']]); 
             
            return response()->json(['message' => 'Datos guardados correctamente'], 200);

        }
        else {
            // return redirect('gestor')->with('warning','El registro no se pudo llevar a cabo');
            return back()->with(['json' => ['message' => 'El registro no se pudo llevar a cabo']]);
            
        } 

       


    }
   
    


 
     


}

 