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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//si el usuario esta logueado
Route::group(['middleware' => ['auth']], function () {
    //empleados
    Route::get('/empleados', 'EmpleadoController@empleados')->name('empleados');    
    Route::get('/obtener_empleados', 'EmpleadoController@obtener_empleados')->name('obtener_empleados');  
    Route::get('/obtener_ultimo_id_empleado', 'EmpleadoController@obtener_ultimo_id_empleado')->name('obtener_ultimo_id_empleado');
    Route::get('/obtener_fecha_actual_datetimelocal', 'EmpleadoController@obtener_fecha_actual_datetimelocal')->name('obtener_fecha_actual_datetimelocal');
    Route::get('/obtener_empresas', 'EmpleadoController@obtener_empresas')->name('obtener_empresas');
    Route::get('/obtener_departamentos', 'EmpleadoController@obtener_departamentos')->name('obtener_departamentos');
    Route::get('/obtener_departamentos_filtro', 'EmpleadoController@obtener_departamentos_filtro')->name('obtener_departamentos_filtro');
    Route::post('/guardar_empleado', 'EmpleadoController@guardar_empleado')->name('guardar_empleado');
    Route::get('/empleados_exportar_excel', 'EmpleadoController@empleados_exportar_excel')->name('empleados_exportar_excel');
    Route::get('/verificar_baja_empleado', 'EmpleadoController@verificar_baja_empleado')->name('verificar_baja_empleado');
    Route::post('/baja_empleado', 'EmpleadoController@baja_empleado')->name('baja_empleado');
    Route::get('/obtener_empleado', 'EmpleadoController@obtener_empleado')->name('obtener_empleado');
    Route::post('/guardar_modificacion_empleado', 'EmpleadoController@guardar_modificacion_empleado')->name('guardar_modificacion_empleado');
    //usuarios
    Route::get('/usuarios', 'UserController@usuarios')->name('usuarios');    
    Route::get('/obtener_usuarios', 'UserController@obtener_usuarios')->name('obtener_usuarios'); 
    Route::get('/obtener_ultimo_id_usuario', 'UserController@obtener_ultimo_id_usuario')->name('obtener_ultimo_id_usuario'); 
    Route::get('/obtener_roles', 'UserController@obtener_roles')->name('obtener_roles'); 
    Route::post('/guardar_usuario', 'UserController@guardar_usuario')->name('guardar_usuario'); 
    Route::get('/verificar_baja_usuario', 'UserController@verificar_baja_usuario')->name('verificar_baja_usuario'); 
    Route::post('/baja_usuario', 'UserController@baja_usuario')->name('baja_usuario'); 
    Route::get('/obtener_usuario', 'UserController@obtener_usuario')->name('obtener_usuario'); 
    Route::post('/guardar_modificacion_usuario', 'UserController@guardar_modificacion_usuario')->name('guardar_modificacion_usuario'); 
});