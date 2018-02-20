<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\User;
use App\Pais;

class AxiosController extends Controller
{
    public function getCategorias(){
      return Categoria::all();
    }

    public function getUser($id){
      return User::find($id);
    }
    public function getCategoria($id){
      return Categoria::find($id);
    }

    public function getMembers($id){
      $users = User::where('categoria_id', $id)->get();
      foreach ($users as $key => $user) {
        $user->perfil;
        $user->categoria;
      }
      return $users;
    }

    public function getPaises(){
      return Pais::all();
    }

    public function searchPais(Request $r){
      $pais = Pais::search($r->pais)->orderBy('nombre', 'ASC')->paginate(10);
      return $pais;
    }
    public function searchMember(Request $r){
      $users = User::search($r->nombre, $r->categoria)->orderBy('name', 'ASC')->get();
      foreach ($users as $key => $user) {
        $user->perfil;
        $user->categoria;
      }
      return $users;
    }
}
