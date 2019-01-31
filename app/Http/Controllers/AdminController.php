<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Empresa;
use App\Perfil;
use App\Valoracion;
use App\Programa;
use App\Categoria;
use App\MemberCat;
use App\Pais;
use App\Idioma;
use Storage;
use App\Participantes;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(){
      return view('panel.index');
    }
    public function getEmpresas(){
      $empresas = Empresa::all();

      foreach ($empresas as $key => $perfil) {
        $perfil->user;
        $perfil->pais;
        $perfil->user->categorias;
        foreach ($perfil->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
      }
      return $empresas;

    }

    public function getPaises(){
      $paises =  Pais::orderBy('nombre', 'ASC')->paginate(10);
      foreach ($paises as $key => $pais) {
        $pais->zona;
      }
      return $paises;
    }

    public function getProgramas(){
      $programas =  Programa::orderBy('desc')->get();

      foreach ($programas as $key => $programa) {
        $programa->empresa->pais;
        $programa->participantes;
      }

      return $programas;
    }

    public function getParticipantes($id){
      $participantes = Participantes::where('programa_id', $id)->get();
      foreach ($participantes as $key => $participante) {
        $participante->pais;
      }

      return $participantes;
    }

    public function getUsers(){
      $perfils = Perfil::all();

      foreach ($perfils as $key => $perfil) {
        $perfil->user->valoracion;
        $perfil->pais;
        $perfil->user->categorias;
        foreach ($perfil->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
      }

      return $perfils;
    }

    public function updatePais(Request $r){
      $pais = Pais::find($r->id);
      $pais->nombre = $r->pais;
      $pais->zona_id = $r->zona;

      if ($r->hasFile('flag')) {
        Storage::delete($pais->bandera);
        $pais->bandera = $r->flag->storeAs('/flags', $r->id.'.png');
      }

      $pais->zona->save();
      $pais->save();

      return $pais;

    }

    public function newPais(Request $r){
      $pais = Pais::create([
        'nombre' => $r->nombre,
        'zona_id' => $r->zona
      ]);
      $pais->zona;
      return $pais;
    }

    public function deletePais($id){
      $pais = Pais::find($id);
      $pais->delete();
    }
    public function newIdioma(Request $r){
      $idioma = Idioma::create([
        'nombre' => $r->nombre,
      ]);
      return $idioma;
    }

    public function updateIdioma(Request $r){
      $idioma = Idioma::find($r->id);
      $idioma->nombre = $r->nombre;
      $idioma->save();

      return $idioma;
    }

    public function deleteIdioma($id){
      $idioma = Idioma::find($id);
      $idioma->delete();
    }

    public function updateCategoria(Request $r){
      $categoria = Categoria::find($r->id);
      $categoria->nombre = $r->nombre;
      $categoria->save();

      return $categoria;
    }
    public function newCategoria(Request $r){
      $categoria = Categoria::create([
        'nombre' => $r->nombre,
      ]);
      return $categoria;
    }

    public function deleteCategoria($id){
      $categoria = Categoria::find($id);
      $categoria->delete();
    }

    public function updateUser(Request $r){
      $user = Perfil::where('user_id', $r->id)->first();

      if ($r->magic === 'name') {
        $user->name = $r->value;
      }
      if ($r->magic === 'apellidos') {

        $user->apellido_p = $r->value_p;
        $user->apellido_m = $r->value_m;
      }
      if ($r->magic === 'tel') {
        $user->telefono = $r->value;
      }
      if ($r->magic === 'cel') {
        $user->celular = $r->value;
      }
      if ($r->magic === 'folio') {
        $user->user->folio = $r->value;
      }
      if ($r->magic === 'fb') {
        $user->fb = $r->value;
      }
      if ($r->magic === 'tw') {
        $user->tw = $r->value;
      }
      if ($r->magic === 'in') {
        $user->in = $r->value;
      }
      if ($r->magic === 'web') {
        $user->website = $r->value;
      }
      if ($r->magic === 'email') {
        $user->user->email = $r->value;
      }
      if ($r->magic === 'pass') {
        $user->user->password = Hash::make($r->value);
      }
      if ($r->magic === 'pais') {
        $user->pais_id = $r->value;
      }
      if ($r->magic === 'cd') {
        $user->ciudad = $r->value;
      }
      if ($r->magic === 'cv') {
        $user->resumen = $r->value;
      }
      if ($r->magic === 'ed') {
        $user->educacion = $r->value;
      }
      if ($r->magic === 'idiomas') {
        $user->idiomas = json_encode($r->idiomas);
      }
      if ($r->magic === 'rango') {
        $user->rango = $r->value;
      }
      if ($r->magic === 'cat') {
        $categorias = MemberCat::where('user_id', $r->id)->get();
        foreach ($categorias as $key => $categoria) {
          $categoria->delete();
        }
        $ncategorias = json_decode($r->categorias);
        foreach ($ncategorias as $key => $cat) {
          MemberCat::create([
            'user_id' => $r->id,
            'categoria_id' => $cat->categoria_id
          ]);
        }

      }

      if ($r->magic === 'pic') {
        if ($r->hasFile('file')) {
          Storage::delete($user->foto);
          $user->foto = $r->file->store('/users/'.$user->id.'/profile_pics');
        }
      }
      $user->save();
      $user->user->save();
      $user->pais;

      foreach ($user->user->categorias as $key => $categoria) {
        $categoria->categoria;
      }

      return $user;

    }
    public function updateEmpresa(Request $r){
      $user = Empresa::where('user_id', $r->id)->first();

      if ($r->magic === 'name') {
        $user->name = $r->value;
      }

      if ($r->magic === 'tel') {
        $user->telefono = $r->value;
      }

      if ($r->magic === 'folio') {
        $user->user->folio = $r->value;
      }
      if ($r->magic === 'fb') {
        $user->fb = $r->value;
      }
      if ($r->magic === 'tw') {
        $user->tw = $r->value;
      }
      if ($r->magic === 'in') {
        $user->in = $r->value;
      }
      if ($r->magic === 'web') {
        $user->website = $r->value;
      }
      if ($r->magic === 'pais') {
        $user->pais_id = $r->value;
      }
      if ($r->magic === 'cd') {
        $user->ciudad = $r->value;
      }
      if ($r->magic === 'cv') {
        $user->descripcion = $r->value;
      }
      if ($r->magic === 'ed') {
        $user->cv = $r->value;
      }
      if ($r->magic === 'idiomas') {
        $user->idiomas = json_encode($r->idiomas);
      }
      if ($r->magic === 'rango') {
        $user->rango = $r->value;
      }

      if ($r->magic === 'pic') {
        if ($r->hasFile('file')) {
          Storage::delete($user->foto);
          $user->foto = $r->file->store('/users/'.$user->id.'/profile_pics');
        }
      }
      $user->save();
      $user->pais;
      $user->user;

      return $user;

    }

    public function updatePrograma(Request $r){

      $programa = Programa::find($r->id);;

      if ($r->magic === 'name') {
        $programa->nombre = $r->value;
      }

      if ($r->magic === 'duracion') {
        $programa->duracion = $r->value;
      }

      if ($r->magic === 'empresa') {
        $programa->empresa_id = $r->value;
      }


      if ($r->magic === 'alcance') {
        $programa->alcance = $r->value;
      }

      if ($r->magic === 'participantes') {

      }


      if ($r->magic === 'pic') {
        if ($r->hasFile('file')) {
          Storage::delete($programa->foto);
          $programa->foto = $r->file->store('/users/'.$programa->id.'/profile_pics');
        }
      }
      $programa->save();

      $programa->empresa->pais;

      return $programa;

    }

    public function deleteValoration($id){
      $valoracion = Valoracion::find($id);
      $valoracion->delete();
      return 1;
    }

    public function updateValoration(Request $r){
      $valoracion = Valoracion::find($r->id);

      if ($r->magic === 'name') {
        $valoracion->area = $r->name;
      }else{
        $valoracion->porcentaje = $r->percent;
      }
      $valoracion->save();
      return $valoracion;
    }

    public function addParticipant(Request $r){
      $participante = Participantes::create([
        'nombre' => $r->nombre,
        'pais_id' => $r->pais,
        'folio' => $r->folio,
        'programa_id' => $r->programa,
        'user_id' => 0,
      ]);

      return $participante;
    }

    public function addValoration($id, Request $r){
      $val = Valoracion::create([
        'area' => $r->area,
        'porcentaje' => $r->percent,
        'user_id' => $id,
        'programa_id' => 0
      ]);

      return $val;
    }
}
