<?php

use App\Http\Controllers\admin\EstadoResidente;
use App\Http\Controllers\admin\LocalidadController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\PuertaController;
use App\Http\Controllers\admin\ResidenteController;
use App\Http\Controllers\admin\SectorController;
use App\Http\Controllers\admin\VisitanteController;
use App\Http\Controllers\admin\RegistroController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('theme/lte/layout');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

/* rutas de sector */
Route::resource('sector', App\Http\Controllers\admin\SectorController::class)->names([
    'store' => 'sector.guardar',
    'destroy' => 'sector.eliminar',
    'edit' => 'sector.editar',
    'update' => 'sector.actualizar',
])->middleware('auth');
Route::get('sector.listar{page?}', [SectorController::class, 'listar'])->name('sector.listar')->middleware('auth');
/* rutas de sector */
/* rutas de puerta */
Route::resource('puerta', App\Http\Controllers\admin\PuertaController::class)->names([
    'store' => 'puerta.guardar',
    'destroy' => 'puerta.eliminar',
])->middleware('auth');
Route::get('puerta.listar{page?}', [PuertaController::class, 'listar'])->name('puerta.listar')->middleware('auth');;
/* rutas de puerta */
/* rutas de edificioPuerta */
Route::view('sectorPuerta', 'admin/ubicacion/sectorPuerta/index')->name('sectorPuerta')->middleware('auth');
/* rutas de edificioPuerta */
/* rutas de localidad */
Route::resource('localidad', App\Http\Controllers\admin\localidadController::class)->names([
    'index' => 'localidad',
    'store' => 'localidad.guardar',
    'edit' => 'localidad.editar',
    'update' => 'localidad.actualizar',
    'destroy' => 'localidad.eliminar',
])->middleware('auth');
Route::get('localidad.listar{page?}', [LocalidadController::class, 'listar'])->name('localidad.listar');
Route::get('localidad.checkSector', [LocalidadController::class, 'checkSector'])->name('localidad.checkSector');
/* rutas de localidad */
/* rutas de residente */
Route::resource('residente', App\Http\Controllers\admin\residenteController::class)->names([
    'index' => 'residente',
    'store' => 'residente.guardar',
    'edit' => 'residente.editar',
    'update' => 'residente.actualizar',
    'destroy' => 'residente.eliminar',
])->middleware('auth');
Route::get('residente.listar{page?}', [ResidenteController::class, 'listar'])->name('residente.listar');
Route::get('residente.sectorBusqueda', [ResidenteController::class, 'sectorBusqueda'])->name('residente.sectorBusqueda');
Route::get('residente.localidadBusqueda', [ResidenteController::class, 'localidadBusqueda'])->name('residente.localidadBusqueda');
/* rutas de residente */
/* rutas de visitante */
Route::resource('visitante', App\Http\Controllers\admin\VisitanteController::class)->names([
    'index' => 'visitante',
    'store' => 'visitante.guardar',
    'edit' => 'visitante.editar',
    'update' => 'visitante.actualizar',
    'destroy' => 'visitante.eliminar',
])->middleware('auth');
Route::get('visitante.listar{page?}', [VisitanteController::class, 'listar'])->name('visitante.listar');
Route::get('visitante.dentro', [VisitanteController::class, 'dentro'])->name('visitante.dentro');
Route::get('visitante.dentro.buscar', [VisitanteController::class, 'buscar'])->name('visitante.dentro.buscar');
Route::post('visitante.darSalida', [VisitanteController::class, 'darSalida'])->name('visitante.darSalida');
/* rutas de visitante */
/* rutas de registro */
Route::middleware('auth')->prefix('registro/')->name('registro.')->controller(RegistroController::class)->group(function () {
    Route::get('index', 'index')->name('registro');
    Route::post('store', 'store')->name('guardar');
    Route::get('residentes{page?}', 'residentes')->name('residentes');
    Route::get('registros{page?}',  'registros')->name('registros');
    Route::get('visitante{page?}',  'visitantes')->name('visitantes');
    Route::get('puertas{page?}',    'puertas')->name('puertas');
    Route::get('autoriza{page?}',   'autoriza')->name('autoriza');
    Route::get('ingresa{page?}',    'ingresa')->name('ingresa');
});
/* rutas de registro */
/* rutas de estadoResidente */
Route::middleware('auth')->prefix('estadoResidente/')->name('estadoResidente.')->controller(EstadoResidente::class)->group(function () {
    Route::get('index', 'index')->name('index');
    Route::get('residentes/{id}', 'residentes')->name('residentes');
    Route::get('update', 'update')->name('update');
});
/* rutas de estadoResidente */
