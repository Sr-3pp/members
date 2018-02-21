<?php
use App\User;
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
      $categorias = User::all()->unique('categoria')->all();
      return view('welcome', compact('categorias'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Rutas-------------------------------------------------------------------------------------------->

Route::get('/get-categorias', 'AxiosController@getCategorias');
Route::get('/get-user/{id}', 'AxiosController@getUser');
Route::get('/get-categoria/{id}', 'AxiosController@getCategoria');
Route::get('/get-members/{id}', 'AxiosController@getMembers');
Route::get('/get-paises', 'AxiosController@getPaises');
Route::post('/search-members', 'AxiosController@searchMember');
Route::post('/search-pais', 'AxiosController@searchPais');

Route::get('perfil/{folio}', 'Controller@getPerfil');

//Route::get('/home', 'GuestController@index');
Route::any('/resultados', 'GuestController@resultados')->middleware('blank');
Route::any('categoria/{categoria}', 'GuestController@categorias');
Route::any('categorias/programas', 'GuestController@programas');
Route::any('/show/{id}', 'GuestController@show');
Route::any('/programa-show/{id}', 'GuestController@programaShow');
Route::any('register-empresa', 'Auth\RegisterController@addEmpresa');


//Mailing routes----------------------------------------------------------------------------------->
Route::get('enviar', ['as' => 'enviar', function () {

    $data = ['link' => 'http://styde.net'];

    \Mail::send('emails.notificacion', $data, function ($message) {

        $message->from('jruiz@kaloni.com', 'kaloni.com');

        $message->to('martin.ru@outlook.com')->subject('Notificación');

    });

    return "Se envío el email";
}]);

Route::get('test-user', 'Controller@test');
