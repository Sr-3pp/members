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


    public function getPerfil(Request $r, $folio){
      $profile;
      $url = $r->url();

      if(strpos($url, 'programa') !== false){
        $profile = Programa::find($folio);
        $profile->pais = $profile->empresa->pais;
        $user = $profile->empresa;
      }else{
        $user = User::where('folio', $folio)->first();
        $profile = ($user->perfil) ? $user->perfil : $user->empresa;
      }
      if ($profile->status === 0) {
        return redirect()->route('home');
      }
      $contact = [
        "telefono" => ($profile->telefono) ? $profile->telefono : $user->telefono,
        "celular" => ($profile->celular) ? $profile->celular : $user->celular,
        "email" => ($user->email) ? $user->email : $user->user->email,
        "website" => ($profile->website) ? $profile->website : $user->website,
        "social" => [
          "fb" => ($profile->fb) ? $profile->fb : $user->fb,
          "tw" => ($profile->tw) ? $profile->tw : $user->tw,
          "in" => ($profile->in) ? $profile->in : $user->in,
          "insta" => ($profile->insta) ? $profile->insta : $user->insta
        ]
      ];
      $categories = $user->categorias;
      $empresa = ($user->empresa) ? $user->empresa : $user;
      $user_folio = ($user->folio) ? $user->folio : $user->user->folio;
      $user_id = ($user->id) ? $user->id : $user->user->id;

      return view('profile', compact(['profile', 'contact', 'categories', 'empresa', 'user_folio', 'user_id']));
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

        foreach ($perfiles as $key => $perfil) {

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
        $perfiles = Perfil::where('pais_id', $r->pais)
                            ->with('user.categorias.categoria')
                            ->with('pais')
                            ->get();
        $empresas = Empresa::where('pais_id', $r->pais)
                            ->with('user.categorias.categoria')
                            ->with('pais')
                            ->get();
        foreach ($perfiles as $key => $perfil) {
          foreach ($cats as $key => $cat) {

            if ($perfil->user_id === $cat->user_id) {
              $perfil->categoria_id = $cat->categoria_id;
            }
          }
          array_push($results, $perfil);
        }

        foreach ($empresas as $key => $perfil) {
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
          $p->valoracion;
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
        $perfiles = Perfil::where('pais_id', $r->pais)->get();
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

    public function purgeProfiles(){
      $users = User::all();
      foreach ($users as $key => $u) {
        if(!$u->perfil && $u->type != 3 && $u->type != 0){
          //$u->delete();
        }
      }

      return 'purged';
    }


}
