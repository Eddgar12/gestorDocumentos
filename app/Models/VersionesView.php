<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionesView //extends Model
{
    /**
     * @var integer
    */
    public $VersionID;
    /**
     * @var integer 
    */
    public $Numero;
    /**
     * @var integer 
    */
    public $DocumentoFk;

    /**
     * @var string
    */
    public $Documento;

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
