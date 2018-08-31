<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User;
use App\MemberCat;
use App\Categoria;
use App\Programa;
use App\Empresa;
use App\Perfil;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getPerfil($folio){
      $user = User::where('folio', $folio)->first();
      return view('perfil', compact('user'));
    }
    public function getEmpresa($folio){
      $user = User::where('folio', $folio)->first();
      return view('perfile', compact('user'));
    }
    public function getPrograma($id){
      $programa = Programa::find($id);
      return view('perfilp', compact('programa'));
    }

    public function search(Request $r){
      $results = [];
      $resultados = [];
      $cats = MemberCat::all();
      if ($r->pais) {
        $perfiles = Perfil::where('pais_id', $r->pais)->paginate(15);
        $empresas = Empresa::where('pais_id', $r->pais)->get();
        foreach ($perfiles as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          foreach ($cats as $key => $cat) {

            if ($perfil->user_id === $cat->user_id) {
              $perfil->categoria_id = $cat->categoria_id;
            }
          }
          array_push($results, $perfil);
        }

        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          foreach ($cats as $key => $cat) {

            if ($perfil->user_id === $cat->user_id) {
              $perfil->categoria_id = $cat->categoria_id;
            }
          }
          array_push($results, $perfil);
        }

      }
      if ($r->categoria !== 0) {
        $categorias = MemberCat::where('categoria_id', $r->categoria)->get();
        foreach ($categorias as $key => $cat) {
          $perfiles = Perfil::where('user_id', $cat->user_id)->get();
          foreach ($perfiles as $key => $perfil) {
            $perfil->user->pais;
            array_push($results, $perfil);
          }
          $empresas = Empresa::where('user_id', $cat->user_id)->get();
          foreach ($empresas as $key => $perfil) {
            $perfil->user->pais;
            array_push($results, $perfil);
          }
        }
      }
      if ($r->nombre !== null) {

        $empresas = Empresa::search($r->nombre)->orderBy('name', 'ASC')->get();
        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          foreach ($cats as $key => $cat) {

            if ($perfil->user_id === $cat->user_id) {
              $perfil->categoria_id = $cat->categoria_id;
            }
          }
          array_push($results, $perfil);
        }
        $perfiles = Perfil::search($r->nombre)->orderBy('name', 'ASC')->get();
        foreach ($perfiles as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          foreach ($cats as $key => $cat) {

            if ($perfil->user_id === $cat->user_id) {
              $perfil->categoria_id = $cat->categoria_id;
            }
          }
          array_push($results, $perfil);
        }

      }

      if ($r->pais && $r->nombre !== null && $r->categoria !== 0) {
        foreach ($results as $key => $resultado) {
          if (count($resultados) !== 0) {
            foreach ($resultados as $key2 => $value) {
              if ($resultado->user_id === $value->user_id ) {
                unset($resultados[$key2]);
              }else{
                array_push($resultados, $resultado);
              }
            }
          }else{
            array_push($resultados, $resultado);
          }
        }

        return $resultados;
      }else if($r->pais && $r->nombre !== null){
        foreach ($results as $key => $resultado) {
          if (count($resultados) !== 0) {
            foreach ($resultados as $key2 => $value) {
              if ($resultado->user_id === $value->user_id ) {
                unset($resultados[$key2]);
              }else{
                array_push($resultados, $resultado);
              }
            }
          }else{
            array_push($resultados, $resultado);
          }
        }

        return $resultados;
      }else if ($r->categoria !== 0 && $r->nombre !== null) {
        foreach ($results as $key => $resultado) {
          if (count($resultados) !== 0) {
            foreach ($resultados as $key2 => $value) {
              if ($resultado->user_id === $value->user_id ) {
                unset($resultados[$key2]);
              }else{
                array_push($resultados, $resultado);
              }
            }
          }else{
            array_push($resultados, $resultado);
          }
        }

        return $resultados;
      }else if($r->categoria !== 0 && $r->pais){
        foreach ($results as $key => $resultado) {
          if (count($resultados) !== 0) {
            foreach ($resultados as $key2 => $value) {
              if ($resultado->user_id === $value->user_id ) {
                unset($resultados[$key2]);
              }else{
                array_push($resultados, $resultado);
              }
            }
          }else{
            array_push($resultados, $resultado);
          }
        }

        return $resultados;
      }else{
        return $results;
      }
    }

    public function test(){
      $user= User::find(1);
      return $user->categorias;
    }


}
