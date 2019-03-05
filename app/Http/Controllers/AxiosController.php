<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categoria;
use App\User;
use App\Perfil;
use App\Pais;
use App\MemberCat;
use App\Idioma;
use App\Valoracion;
use App\Programa;
use App\Empresa;
use App\Zona;
use Storage;

class AxiosController extends Controller
{
    public function getCategorias(){
      return Categoria::all();
    }

    public function getUser($id){
      $user =  User::find($id);
      $user->perfil;
      $user->empresa;
      return $user;
    }
    public function getCategoria($id){
      return Categoria::find($id);
    }

    public function getMembers($id){

      $categorias = MemberCat::where('categoria_id', $id)->get();

      $members = [];
      if ($id === '5') {


      }else{
        foreach ($categorias as $key => $categoria) {
          if ($id === '4') {
            $categoria->user->empresa->pais;
            $members[$key] = $categoria->user;
          }else{
            $categoria->user->perfil->pais;
            $members[$key] = $categoria->user;
          }
        }
      }
      return $members;
    }

    public function getPaises(){
      $paises =  Pais::orderBy('nombre', 'asc')->get();

      return $paises;
    }
    public function getIdiomas(){
      $idiomas =  Idioma::orderBy('nombre', 'ASC')->get();

      return $idiomas;
    }

    public function searchPais(Request $r){
      $paises = Pais::search($r->pais)->orderBy('nombre', 'asc')->paginate(10);
      foreach ($paises as $key => $pais) {
        $pais->zona;
      }
      return $paises;
    }
    public function searchIdioma(Request $r){
      $idiomas = Idioma::search($r->idioma)->paginate(10);

      return $idiomas;
    }
    public function searchPrograma(Request $r){
      $programas = Programa::search($r->programa)->orderBy('nombre')->get();
      foreach ($programas as $key => $programa) {
        $programa->empresa->pais;
        $programa->participantes;
        $programa->valoracion;
      }
      return $programas;
    }
    public function searchMember(Request $r){
      $perfiles = Perfil::search($r->nombre, 'name')->orderBy('name', 'ASC')->get();
      if (count($perfiles) == 0) {
        $perfiles = Perfil::search($r->nombre, 'app_p')->orderBy('name', 'ASC')->get();
      }
      if(count($perfiles) == 0){
        $perfiles = Perfil::search($r->nombre, 'app_m')->orderBy('name', 'ASC')->get();
      }
      $resultados = [];
      foreach ($perfiles as $key => $perfil) {
        if ($perfil->status === 1) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          $perfil->user->valoracion;
          array_push($resultados, $perfil->user);
          $resultados[$key]["perfil"] = $perfil->user->perfil;
          $resultados[$key]["perfil"]["pais"] = $perfil->pais;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
        }
      }
      if ($r->magic === '2') {
        return $perfiles;
      }
      return $resultados;
    }
    public function searchEmpresa(Request $r){
      $perfiles = Empresa::search($r->empresa)->orderBy('name', 'ASC')->get();
      foreach ($perfiles as $key => $perfil) {
        $perfil->user;
        $perfil->pais;
        $perfil->user->categorias;
        $perfil->user->valoracion;
        foreach ($perfil->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
      }
      return $perfiles;
    }

    public function getLanguajes($search){
      $languajes = Idioma::search($search)->orderBy('nombre', 'asc')->get();
      return $languajes;
    }
    public function getLanguajesAll(){
      $languajes = Idioma::orderBy('nombre', 'asc')->get();
      return $languajes;
    }

    public function getVals($id){
      return Valoracion::where('user_id', $id)->get();
    }

    public function searchEmpresas(Request $r){
      $empresas = Empresa::search($r->nombre)->orderBy('name', 'ASC')->get();
      foreach ($empresas as $key => $perfil) {
        $perfil->user;
        $perfil->pais;
        $perfil->user->categorias;
        $perfil->user->valoracion;
        foreach ($perfil->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
      }
      return $empresas;
    }

    public function getProgramas(){
      $programas = Programa::all();
      foreach ($programas as $key => $programa) {

        $programa->empresa->pais;
        $programa->empresa->user;
        $programa->participantes;
      }

      return $programas;
    }

    public function getPrograma($id){
      $programa = Programa::find($id);
      $programa->participantes;
      $programa->empresa->pais->zona;
      foreach ($programa->participantes as $key => $part) {
        $part->pais;
        $part->pais->zona;
      }

      return $programa;
    }

    public function getZonas(){
      return Zona::all();
    }

}
