<?php

use App\Http\Controllers\gestorController;
use App\Http\Controllers\documentoController; 
use App\Http\Controllers\principalController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// crear una vista con el controlardor
/* 
    Inicializar apache2 y mariadb
    sudo service apache2 start
    sudo service mariadb start

    sudo php artisan serve --port 8000
    //http://localhost:8000/gestor
*/ 

Route::resource('gestor',gestorController::class);  

/**---- ----------------------CRUD | Route PARA FORMULARIO DOCUMENTOS --------------------------------- */
// Route::post('/frmdocumentos',[gestorController::class,'store'])->name('frmdocumentos');  

Route::post('gestor/store', [gestorController::class, 'store'])->name('store');

// Route::get('phpmyinfo', function () {
//     phpinfo(); 
// })->name('phpmyinfo');
 
/** vDocumento ----------------------- VISTA DOCUMENTO ------------------ */ 
// Vista  ------------------------- Registro DocumentoID
Route::get('/documento/{id}',[documentoController::class, 'show']);  
// Editar -------------------------- Registro (datos| estatus) ----------------------- 
Route::post('/documento/update', [documentoController::class, 'update']); 
// Eliminar -------------------------- Registro --------------------------------------  
Route::get('documento/delete/{id}',[documentoController::class,'delete']);
// DESCARGAR DOCUMENTO ------------------------ vista iframe | descargar  --------------------------- 
// Route::get('documento/download/{id}/{opcion}',[documentoController::class,'download']);

// VISTA versiones ------------------------ vista iframe | descargar  --------------------------- 
Route::get('documento/download/{id}/{version}/{opcion}',[documentoController::class,'download']);
 
 