<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use App\Models\DocumentosView;
use App\Models\VersionesView;

class DetalleView  
{
    // use HasFactory;

    /**
     *  @var DocumentosView[]
     */
    public $data = [];

    /**
     *  @var VersionesView[]
     */
    public $versiones = [];
}
