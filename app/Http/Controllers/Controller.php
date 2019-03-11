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
          if ($perfil->status === 1) {
            array_push($results, $perfil);
          }
        }
        $perfiles = Perfil::search($r->nombre, 'name')->orderBy('name', 'ASC')->get();
        if (count($perfiles) == 0) {
          $perfiles = Perfil::search($r->nombre, 'app_p')->orderBy('name', 'ASC')->get();
        }
        if(count($perfiles) == 0){
          $perfiles = Perfil::search($r->nombre, 'app_m')->orderBy('name', 'ASC')->get();
        }
        if(count($perfiles) == 0){
          $users = User::search($r->nombre)->orderBy('folio', 'ASC')->get();
          $perfiles = [];
          foreach ($users as $key => $user) {
            array_push($perfiles, $user->perfil);
          }
        }
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
          if ($perfil->status === 1) {
            array_push($results, $perfil);
          }
        }

      }
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
      if ($r->categoria !== 0 && $r->categoria !== 5) {
        $categorias = MemberCat::where('categoria_id', $r->categoria)->get();
        foreach ($categorias as $key => $cat) {
          $perfiles = Perfil::where('user_id', $cat->user_id)->get();
          foreach ($perfiles as $key => $perfil) {
            $perfil->user;
            $perfil->pais;
            $perfil->user->categorias;
            if (count($perfil->user->categorias) > 1) {
              foreach ($perfil->user->categorias as $key => $categoria) {
                if ($categoria->categoria_id === $r->categoria) {
                  $perfil->categoria_id = $r->categoria;
                }
              }
            }else{
              foreach ($cats as $key => $cat) {
                if ($perfil->user_id === $cat->user_id) {
                  $perfil->categoria_id = $cat->categoria_id;
                }
              }
            }
            if($perfil->status === 1){
              array_push($results, $perfil);
            }
          }
          $empresas = Empresa::where('user_id', $cat->user_id)->get();
          foreach ($empresas as $key => $perfil) {
            $perfil->user;
            $perfil->pais;
            $perfil->user->categorias;
            if (count($perfil->user->categorias) > 1) {
              foreach ($perfil->user->categorias as $key => $categoria) {
                if ($categoria->categoria_id === $r->categoria) {
                  $perfil->categoria_id = $r->categoria;
                }
              }
            }else{
              foreach ($cats as $key => $cat) {
                if ($perfil->user_id === $cat->user_id) {
                  $perfil->categoria_id = $cat->categoria_id;
                }
              }
            }
            if ($perfil->status === 1) {
              array_push($results, $perfil);
            }
          }
        }
      }else if($r->categoria == 5){
        $programas = Programa::where('status', 1)->get();
        foreach ($programas as $key => $p) {
          $p->empresa;
          $p->empresa->user;
          $p->empresa->pais;
        }
        return $programas;
      }


      if ($r->nombre !== null && $r->pais && $r->categoria !== 0) {
        $empresas = Empresa::search($r->nombre)->orderBy('name', 'ASC')->get();
        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }
        $perfiles = Perfil::search($r->nombre, 'name')->orderBy('name', 'ASC')->get();
        if (count($perfiles) == 0) {
          $perfiles = Perfil::search($r->nombre, 'app_p')->orderBy('name', 'ASC')->get();
        }
        if(count($perfiles) == 0){
          $perfiles = Perfil::search($r->nombre, 'app_m')->orderBy('name', 'ASC')->get();
        }
        foreach ($perfiles as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }

        foreach ($resultados as $key => $result) {
          if ($result->pais_id !== $r->pais) {
            unset($resultados[$key]);
          }
          if ($result->categoria_id !== $r->categoria) {
            unset($resultados[$key]);
          }
          if ($result->status !== 1) {
            unset($resultados[$key]);
          }
        }

        return $resultados;
      }else if($r->nombre !== null && $r->pais){
        $empresas = Empresa::search($r->nombre)->orderBy('name', 'ASC')->get();
        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }
        $perfiles = Perfil::search($r->nombre, 'name')->orderBy('name', 'ASC')->get();
        if (count($perfiles) == 0) {
          $perfiles = Perfil::search($r->nombre, 'app_p')->orderBy('name', 'ASC')->get();
        }
        if(count($perfiles) == 0){
          $perfiles = Perfil::search($r->nombre, 'app_m')->orderBy('name', 'ASC')->get();
        }
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
          array_push($resultados, $perfil);
        }

        foreach ($resultados as $key => $result) {
          if ($result->pais_id !== $r->pais) {
            unset($resultados[$key]);
          }
          if ($result->status !== 1) {
            unset($resultados[$key]);
          }
        }

        return $resultados;
      }else if ($r->nombre !== null && $r->categoria !== 0) {
        $empresas = Empresa::search($r->nombre)->orderBy('name', 'ASC')->get();
        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }
        $perfiles = Perfil::search($r->nombre, 'name')->orderBy('name', 'ASC')->get();
        if (count($perfiles) == 0) {
          $perfiles = Perfil::search($r->nombre, 'app_p')->orderBy('name', 'ASC')->get();
        }
        if(count($perfiles) == 0){
          $perfiles = Perfil::search($r->nombre, 'app_m')->orderBy('name', 'ASC')->get();
        }
        foreach ($perfiles as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          if ($perfil->status === 1) {
            array_push($resultados, $perfil);
          }
        }


        return $resultados;
      }else if($r->pais && $r->categoria !== 0){
        $perfiles = Perfil::where('pais_id', $r->pais)->paginate(15);
        $empresas = Empresa::where('pais_id', $r->pais)->get();
        foreach ($perfiles as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }

        foreach ($empresas as $key => $perfil) {
          $perfil->user;
          $perfil->pais;
          $perfil->user->categorias;
          foreach ($perfil->user->categorias as $key => $categoria) {
            $categoria->categoria;
          }
          if (count($perfil->user->categorias) > 1) {
            foreach ($perfil->user->categorias as $key => $categoria) {
              if ($categoria->categoria_id === $r->categoria) {
                $perfil->categoria_id = $r->categoria;
              }
            }
          }else{
            foreach ($cats as $key => $cat) {
              if ($perfil->user_id === $cat->user_id) {
                $perfil->categoria_id = $cat->categoria_id;
              }
            }
          }
          array_push($resultados, $perfil);
        }

        foreach ($resultados as $key => $result) {
          if ($result->categoria_id !== $r->categoria) {
            unset($resultados[$key]);
          }
          if ($result->status === 0) {
            unset($resultados[$key]);
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
