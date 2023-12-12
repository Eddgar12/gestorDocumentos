<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentosView //extends Model
{  
    /**
     * @var integer 
    */
    public $DocumentoID;

    /**
     * @var string
    */
    public $Documento;

    /**
     * @var integer
    */
    public $VersionFk;

    /**
     * @var integer
    */
    public $Version;

    /**
     * @var string
    */
    public $Oficio;

    /**
     * @var string
    */
    public $Descripcion;

    /**
     * @var integer
    */
    public $AreaFk;

    /**
     * @var string
    */
    public $Area;
    
    /**
     * @var integer
    */
    public $TipoDocumentoFk;

    /**
     * @var string
    */
    public $TipoDocumento;

    /**
     * @var integer
    */
    public $NormaFk;

    /**
     * @var string
    */
    public $Norma;

    /**
     * @var integer
    */
    public $TipoMateriaFk;

    /**
     * @var string
    */
    public $TipoMateria;

    /**
     * @var string
    */
    public $EstatusFk;

    /**
     * @var string
    */
    public $Estatus;

    /**
     * @var string
    */
    public $Ruta;

    /**
     *@var string
    */
    public $FechaEmision;


}
