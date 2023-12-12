<?php

namespace App\Http\Controllers;

use App\Models\DetalleView;
use App\Models\documentos;
use App\Models\versiones;
use App\Models\DocumentosView;
use App\Models\VersionesView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use Faker\Core\Version;

use function Symfony\Component\String\b;

class documentoController extends Controller
{    
    public function show($DocumentoID) { 

        $sqlVersiones = versiones::select(  
            'versiones.id AS versionID',
            'versiones.Version AS numero',
            'versiones.DocumentoFk AS documentoFk',
            'versiones.Nombre as nombre',

            'documentos.Oficio as oficio',
            'versiones.EstatusFk AS estatusFk',
            'estatus.Nombre AS estatus',
            'versiones.Ruta AS ruta',
            'documentos.FechaEmision'
        )
        ->leftJoin('documentos','documentos.id','=','versiones.DocumentoFk') 
        ->leftJoin('estatus','estatus.id','=','versiones.EstatusFk')
        ->where('versiones.DocumentoFk','=',$DocumentoID)
        ->orderBy('versiones.Version','asc')
        ->get(); 

        /** @var DetalleView */
        $DocVersiones = new DetalleView(); 
        
        foreach($sqlVersiones as $data)
        {
            $version = new VersionesView();
            $version->VersionID = $data['versionID']; 
            $version->Numero = $data['numero']; 
            $version->Ruta = $data['ruta']; 
            $version->DocumentoFk = $data['documentoFk'];
            $version->Documento = $data['nombre'];
            $version->Oficio = $data['oficio'];
            $version->Estatus = $data['estatus'];
            $aux = $data['FechaEmision']; 
            $version->FechaEmision  = date("d-m-Y", strtotime($aux));  

            array_push($DocVersiones->versiones, $version);
        }  

        $sqlDocumento = documentos::select(
            'documentos.id AS documentoID',
            'versiones.Nombre AS nombre', 
 
            'versiones.id AS versionID',
            'versiones.Version AS numero',
            'versiones.Ruta AS ruta',
            
            'documentos.Oficio as oficio',
            'documentos.Descripcion as descripcion',
            'documentos.areaFk',
            'areas.Nombre AS area',
            'documentos.TipoDocumentoFk AS tipoDocumentoFk',
            'tiposDocumentos.Nombre AS tipoDocumentoNombre',
            'documentos.normaFk',
            'normas.Nombre AS norma',
            'documentos.TipoMateriaFk AS tipoMateriaFk', 
            'tiposMaterias.Nombre AS tipoMateria', 
            'documentos.EstatusFk AS estatusFk',
            'estatus.Nombre AS estatus', 
            'documentos.FechaEmision') 
       
        ->leftJoin('versiones','versiones.DocumentoFk','=','documentos.id')
        ->leftJoin('areas','areas.id','=','documentos.AreaFk')
        ->leftJoin('tiposDocumentos','tiposDocumentos.id','=','documentos.TipoDocumentoFk')
        ->leftJoin('normas','normas.id','=','documentos.NormaFk') 
        ->leftJoin('tiposMaterias','tiposMaterias.id','=','documentos.TipoMateriaFk')  
        ->leftJoin('estatus','estatus.id','=','documentos.EstatusFk')
        ->where('documentos.id','=',$DocumentoID)
        ->where('documentos.Activo', '=', 1)
        ->orderBy('versiones.Version','DESC')
        ->limit(1)

        ->get(); 
        
       
        $doc = new DocumentosView();
        
        $doc->DocumentoID = $sqlDocumento [0]["documentoID"];
        $doc->Documento = $sqlDocumento [0]["nombre"];

        $doc->VersionFk = $sqlDocumento [0]["versionID"]; 
        $doc->Version = $sqlDocumento [0]["numero"]; 
        $doc->Ruta = $sqlDocumento [0]["ruta"];

        $doc->Oficio = $sqlDocumento [0]["oficio"];
        $doc->Descripcion = $sqlDocumento [0]["descripcion"];
        $doc->AreaFk = $sqlDocumento [0]["areaFk"];
        $doc->Area = $sqlDocumento [0]["area"]; 
        $doc->TipoDocumentoFk = $sqlDocumento [0]["tipoDocumentoFk"];
        $doc->TipoDocumento = $sqlDocumento [0]["tipoDocumentoNombre"]; 
        $doc->NormaFk = $sqlDocumento [0]["normaFk"];
        $doc->Norma = $sqlDocumento [0]["norma"]; 
        $doc->TipoMateriaFk = $sqlDocumento [0]["tipoMateriaFk"];
        $doc->TipoMateria = $sqlDocumento [0]["tipoMateria"]; 
        $doc->EstatusFk = $sqlDocumento [0]["estatusFk"];
        $doc->Estatus = $sqlDocumento [0]["estatus"];  
        $aux = $sqlDocumento [0]["FechaEmision"];  
        $doc->FechaEmision = date("Y-m-d", strtotime($aux));  
 
        array_push($DocVersiones->data, $doc);
 
        //return view('documento.vDocumento',compact('doc'));  
        return view('documento.vDocumento',compact('doc','version','DocVersiones'));  
    } 

    /**
     * Actualiza los datos del registro almacenado y crea una nueva version
     */
    public function update(Request $request)
    {  
        $DocumentoData = documentos::where('id',$request->documentoID)->first();   
        //              //dd($DocumentoData);
        //              //dd($request); {{$doc->documentoID}} 
        $DocumentoData->Oficio = $request->input('oficio');
        $DocumentoData->Activo = 1;
        $DocumentoData->Descripcion = $request->input('descripcion');
        $DocumentoData->AreaFk = $request->input('areaFk');
        $DocumentoData->TipoDocumentoFk = $request->input('tipoDocumentoFk');
        $DocumentoData->NormaFk = $request->input('normaFk');
        $DocumentoData->TipoMateriaFk = $request->input('tipoMateriaFk');
        $DocumentoData->EstatusFk = $request->input('estatusFk'); 
        $DocumentoData->FechaEmision = $request->input('FechaEmision');
        
        /*-- Guardar registros de archivos AWS S3  Bucket------------------------------- NUEVA VERSION --------------*/ 
        $content = $request->file('archivo'); 
        if($content){
            $tipo = $DocumentoData->TipoDocumentoFk;
            switch($tipo){
                case 1:
                    $documento_Path = Storage::disk('s3')->put('Lineamientos/'.$DocumentoData->Nombre,$content);
                break;
                case 2:
                    $documento_Path = Storage::disk('s3')->put('Manuales/'.$DocumentoData->Nombre,$content);
                break;
                case 3:
                    $documento_Path = Storage::disk('s3')->put('Normas/'.$DocumentoData->Nombre,$content);
                break;
                case 4:
                    $documento_Path = Storage::disk('s3')->put('Procedimientos/'.$DocumentoData->Nombre,$content);
                break; 
            }

            //Verificar si existe el documento y tiene alguna version
            $versionAnterior = versiones::where('DocumentoFk',$request->documentoID)->orderBy('id','DESC')->first();
            $versionAnterior->EstatusFk = 2; 
            $versionAnterior->save();

            $DocumentoVersion = new versiones();    
            $DocumentoVersion->Nombre = $request->input('nombre');
            $DocumentoVersion->Version = $versionAnterior->Version + 1; 
            $DocumentoVersion->DocumentoFk = $versionAnterior->DocumentoFk;        
            $DocumentoVersion->Ruta = $documento_Path;  
            $DocumentoVersion->Activo = 1;
            $DocumentoVersion->EstatusFk = 1; 
            $DocumentoVersion->save();  

        }
        
 

        // $DocumentoVersion = versiones::where('DocumentoFk',$request->documentoID)->first();

        $DocumentoData->save();  
        
        // //Verificar si existe el documento y tiene alguna version
        // $versionAnterior = versiones::where('DocumentoFk',$request->documentoID)->orderBy('id','DESC')->first();
        // $versionAnterior->EstatusFk = 2; 
        // $versionAnterior->save();

        // $DocumentoVersion = new versiones();    
        // $DocumentoVersion->Nombre = $request->input('nombre');
        // $DocumentoVersion->Version = $versionAnterior->Version + 1; 
        // $DocumentoVersion->DocumentoFk = $versionAnterior->DocumentoFk;        
        // $DocumentoVersion->Ruta = $documento_Path;  
        // $DocumentoVersion->Activo = 1;
        // $DocumentoVersion->EstatusFk = 1; 
        // $DocumentoVersion->save();  

        //Verificar si existe el documento y tiene alguna version
        $versionAnterior = versiones::where('DocumentoFk',$request->documentoID)->orderBy('id','DESC')->first();
        $DocumentoVersion->Nombre = $request->input('nombre');
        $versionAnterior->EstatusFk = 2; 
        $versionAnterior->save();

        // $DocumentoVersion = new versiones();    
        // $DocumentoVersion->Nombre = $request->input('nombre');
        // $DocumentoVersion->Version = $versionAnterior->Version + 1; 
        // $DocumentoVersion->DocumentoFk = $versionAnterior->DocumentoFk;        
        // $DocumentoVersion->Ruta = $documento_Path;  
        // $DocumentoVersion->Activo = 1;
        // $DocumentoVersion->EstatusFk = 1; 
        // $DocumentoVersion->save();  
         
        return redirect('documento/'.$DocumentoData->id)->with('success','El registro ha sido actualizado con éxito.');

        
 
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function delete($DocumentoID) {
        $DocumentoData = documentos::where('id',$DocumentoID)->first(); 
        $DocumentoData->Activo = 0;
        
        $DocumentoData->save();   
    }
    
    // public function download($VersionID, $opcion) {
    public function download($DocumentoID, $VersionID, $opcion)  {
        // $DocumentoData = documentos::where('id',$DocumentoID)->first(); 
        //$DocumentoVersion = versiones::where('DocumentoFk',$DocumentoID)->first(); 

        // $DocumentoData = documentos::where('id',$DocumentoID)->first();
        // $DocumentoFK = $DocumentoData->id;

     
        // $DocumentoVersion = versiones::where('id',$VersionID)->first();  
        $DocumentoVersion = versiones::where('id',$VersionID)->where('DocumentoFk',$DocumentoID)->first();
        $path = $DocumentoVersion->Ruta;

        // $aux2= $DocumentoVersion->DocumentoFk;
        
        $acciones = [
            "vistaDocumento" => 1,
            "descargarDocumento" => 2, 
        ];
         
        if(empty($path)) {
            return response()->json(['error' => 'El documento no esta disponible'], 400);
        }

        if(!Storage::disk('s3')->exists($path)){
            return response()->json(['error'=> 'Documento no encontrado'],400);
        }
        //Se obtiene el archivo del bucket S3 
        $content = Storage::disk('s3')->get($path);

        //Se obtiene el nombre y el mime type
        $name = basename($path); 
        // $mime = Storage::disk('s3')->mimeType($path);
        $mime = Storage::mimeType($path);  

        // Respuesta del documento encontrado y los headers 
        if($opcion == $acciones["vistaDocumento"]) {
            $disposition = "inline";
        }
        if($opcion == $acciones["descargarDocumento"]) {
            $disposition = "attachment";
        } 
        return response($content, 200)
        ->header('Content-Type', $mime)
        ->header('Content-Disposition', "$disposition; filename=$name");   
    }

    
    
}
