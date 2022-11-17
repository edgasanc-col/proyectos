<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route Hooks - Do not delete//
	Route::view('anticipos', 'livewire.anticipos.index')->middleware('auth')->name('anticipos');
	Route::view('avances', 'livewire.avances.index')->middleware('auth')->name('avances');
	Route::view('actividades', 'livewire.actividades.index')->middleware('auth')->name('actividades');
	Route::view('resultados', 'livewire.resultados.index')->middleware('auth')->name('resultados');
	Route::view('proyectos', 'livewire.proyectos.index')->middleware('auth')->name('proyectos');
	Route::view('donantes', 'livewire.donantes.index')->middleware('auth')->name('donantes');
	Route::view('rubros', 'livewire.rubros.index')->middleware('auth')->name('rubros');
	Route::view('empleados', 'livewire.empleados.index')->middleware('auth')->name('empleados');
	Route::view('areas', 'livewire.areas.index')->middleware('auth')->name('areas');
	Route::view('organizacions', 'livewire.organizacions.index')->middleware('auth')->name('organizacions');
	Route::view('municipios', 'livewire.municipios.index')->middleware('auth')->name('municipios');
	Route::view('departamentos', 'livewire.departamentos.index')->middleware('auth')->name('departamentos');
	Route::view('paises', 'livewire.paises.index')->middleware('auth')->name('paises');
	Route::view('users', 'livewire.users.index')->middleware('auth')->name('users');
	Route::view('permisos', 'livewire.permisos.index')->middleware('auth')->name('permisos');
	Route::view('modulos', 'livewire.modulos.index')->middleware('auth')->name('modulos');
	Route::view('roles', 'livewire.roles.index')->middleware('auth')->name('roles');
	Route::view('perfil', 'perfil')->middleware('auth')->name('perfil');