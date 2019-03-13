<?php
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

Route::get('/', function(){
  App::setLocale('es');
  return view('welcome');
})->name('home');

//Rutas-------------------------------------------------------------------------------------------->

Route::post('/search', 'Controller@search');
Route::get('/get-categorias', 'AxiosController@getCategorias');
Route::get('/get-zonas', 'AxiosController@getZonas');
Route::get('/get-user/{id}', 'AxiosController@getUser');
Route::get('/get-categoria/{id}', 'AxiosController@getCategoria');
Route::get('/get-members/{id}', 'AxiosController@getMembers');
Route::get('/get-programas', 'AxiosController@getProgramas');
Route::get('/get-programa/{id}', 'AxiosController@getPrograma');
Route::get('/get-languages/{search}', 'AxiosController@getLanguajes');
Route::get('/get-languages-all', 'AxiosController@getLanguajesAll');
Route::get('/get-paises', 'AxiosController@getPaises');
Route::get('/get-idiomas', 'AxiosController@getIdiomas');
Route::post('/search-empresas', 'AxiosController@searchEmpresas');
Route::get('/get-vals/{id}', 'AxiosController@getVals');
Route::get('/get-vals-prog/{id}', 'AxiosController@getValsProg');
Route::post('/search-members', 'AxiosController@searchMember');
Route::post('/search-pais', 'AxiosController@searchPais');
Route::post('/search-idioma', 'AxiosController@searchIdioma');
Route::post('/search-programa', 'AxiosController@searchPrograma');
Route::post('/search-empresa', 'AxiosController@searchEmpresa');


Route::post('/new-membrer', 'MemberController@newMember');
Route::get('/delete-user/{id}', 'MemberController@delete');
Route::get('/status-user/{id}', 'MemberController@status');

Route::get('perfil/{folio}/{slug}', 'Controller@getPerfil');
Route::get('empresa/{folio}/{slug}', 'Controller@getEmpresa');
Route::get('programa/{id}/{slug}', 'Controller@getPrograma');

Route::post('/new-empresa', 'EmpresaController@newEmpresa');
Route::get('/status-programa/{id}', 'ProgramController@status');
Route::post('/new-programa', 'ProgramController@newPrograma');
Route::get('/delete-program/{id}', 'ProgramController@delete');
Route::post('/login-member', 'Auth\LoginController@login');

Route::post('/upload-pic', 'Controller@test');

Route::post('/user-logout', 'Auth\LoginController@logout');

Route::prefix('panel')->middleware('admin')->group(function () {
    Route::get('/', 'AdminController@index');
    Route::get('/get-programas', 'AdminController@getProgramas');
    Route::get('/get-users', 'AdminController@getUsers');
    Route::get('/get-empresas', 'AdminController@getEmpresas');
    Route::get('/get-paises', 'AdminController@getPaises');
    Route::get('/get-participantes/{id}', 'AdminController@getParticipantes');

    Route::get('/delete-pais/{id}', 'AdminController@deletePais');
    Route::get('/delete-idioma/{id}', 'AdminController@deleteIdioma');
    Route::get('/delete-cat/{id}', 'AdminController@deleteCategoria');
    Route::get('/delete-val/{id}', 'AdminController@deleteValoration');

    Route::post('/update-pais', 'AdminController@updatePais');
    Route::post('/update-idioma', 'AdminController@updateIdioma');
    Route::post('/update-categoria', 'AdminController@updateCategoria');
    Route::post('/update-user', 'AdminController@updateUser');
    Route::post('/update-empresa', 'AdminController@updateEmpresa');
    Route::post('/update-programa', 'AdminController@updatePrograma');
    Route::post('/update-val', 'AdminController@updateValoration');

    Route::post('/new-pais', 'AdminController@newPais');
    Route::post('/new-idioma', 'AdminController@newIdioma');
    Route::post('/new-categoria', 'AdminController@newCategoria');
    Route::post('/add-participant', 'AdminController@addParticipant');
    Route::post('/add-valoration/{id}', 'AdminController@addValoration');
});


Route::get('test-user', 'Controller@test');
