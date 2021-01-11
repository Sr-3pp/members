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
        $perfil->user->valoracion;
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
      $programas =  Programa::orderBy('nombre', 'desc')->get();

      foreach ($programas as $key => $programa) {
        $programa->empresa->pais;
        $programa->participantes;
        $programa->valoracion;
        $programa->empresa->user;
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
        $perfil->pais;
        if ($perfil->user) {
          $perfil->user->valoracion;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
        }else{
          Storage::delete($perfil->foto);
          $perfil->delete();
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
      $data = $r->all();
      $user = Perfil::where('user_id', $r->user_id)->first();

      if ($user == null) {
        $user = Empresa::where('user_id', $r->user_id)->first();
      }

      if ($r->password) {
        $data['password'] = Hash::make($r->password);
      }

      if ($r->hasFile('foto')) {
        Storage::delete($user->foto);
        $data['foto'] = $r->foto->store('users/'. $user->user_id . '/');
      }

      if ($r->email) {
        $user->user->email = $r->email;
      }

      if ($r->valoraciones) {
        $uvals = Valoracion::where('user_id', $user->user_id)->get();
        $vals = json_decode($r->valoraciones);
        $vids = [];
        $uvids = [];
        
        foreach ($uvals as $key => $v) {
            array_push($uvids, $v->id);          
        }

        foreach ($vals as $key => $v) {
          if (isset($v->id)) {
            array_push($vids, $v->id);  
            $val = Valoracion::find($v->id);
          
            if ($val->first()) {
              $val->update((array)$v);
            }        
          }else{
            if(count($user->user->valoracion) < 5){
              Valoracion::create([
                'user_id' => $r->user_id,
                'area' => $v->area,
                'porcentaje' => $v->porcentaje
              ]);
            }
          }
        }
        foreach ($uvals as $key => $v) {
          if (!in_array($v->id, $vids)) {
            $v->delete();
          }
        }
      }

      if ($r->categorias) {
        $cats = json_decode($r->categorias);
        $mc = MemberCat::where('user_id', $r->user_id)->get();
        $mcids = [];

        foreach ($mc as $key => $c) {
          array_push($mcids, $c->categoria_id);          
        }
        foreach ($cats as $key => $c) {
          if (!in_array($c, $mcids) && $c != null) {
            MemberCat::create([
              'user_id' => $r->user_id,
              'categoria_id' => $c
            ]);
          }
        }
        
        foreach ($mc as $key => $c) {
          if (!in_array($c->categoria_id, $cats)) {
            $c->delete();
          }
        }
      }

      $user->update($data);

      $user->pais;
      $user->user->save();

      foreach ($user->user->categorias as $key => $categoria) {
        $categoria->categoria;
      }
      $user->user->valoracion;
      return $user;

    }
    public function updateEmpresa(Request $r){
      $user = Empresa::where('user_id', $r->id)->first();

      if ($r->magic === 'name') {
        $user->name = $r->value;
      }
      if ($r->magic === 'email') {
        $user->user->email = $r->value;
      }
      if ($r->magic === 'password') {
        $user->user->password = bcrypt($r->value);
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
      $user->user->save();

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
        if ($r->hasFile('pic')) {
          Storage::delete($programa->foto);
          $programa->foto = $r->pic->store('/users/'.$programa->id.'/profile_pics');
        }
      }
      $programa->save();

      $programa->empresa->pais;
      $programa->participantes;

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
      if($r->magic === 'program'){
        $val = Valoracion::create([
          'area' => $r->area,
          'porcentaje' => $r->percent,
          'user_id' => 0,
          'programa_id' => $id
        ]);
      }else{
        $val = Valoracion::create([
          'area' => $r->area,
          'porcentaje' => $r->percent,
          'user_id' => $id,
          'programa_id' => 0
        ]);
      }

      return $val;
    }
}
