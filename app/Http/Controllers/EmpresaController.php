<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa;
use App\User;
use App\Perfil;
use App\Valoracion;
use App\MemberCat;
use Hash;

class EmpresaController extends Controller
{
  public function newEmpresa(Request $r){
    $users = User::all();
    //$folio2 = count($users)+1;

    $user= User::create([
      'folio' => $r->folio,
      'email' => $r->email,
      'tipo' => 0,
      'password' => Hash::make($r->password)
    ]);

    if ($r->hasFile('file')) {
      $perfil = Empresa::create([
        'user_id' => $user->id,
        'name' => $r->nombre,
        'telefono' => $r->telefono,
        'rango' => $r->membresia,
        'website' => $r->website,
        'foto' => $r->file->store('/users/'.$user->id.'/profile_pics'),
        'fb' => $r->fb,
        'tw' => $r->tw,
        'in' => $r->in,
        'pais_id' => $r->pais,
        'ciudad' => $r->ciudad,
        'nacionalidad' => $r->nacionalidad,
        'idiomas' => json_encode($r->idiomas),
        'cv' => $r->cv,
        'descripcion' => $r->descripcion
      ]);
    }else{
      $perfil = Empresa::create([
        'user_id' => $user->id,
        'name' => $r->nombre,
        'telefono' => $r->telefono,
        'rango' => $r->membresia,
        'website' => $r->website,
        'foto' => '/media/img/defaults/profile_1.png',
        'fb' => $r->fb,
        'tw' => $r->tw,
        'in' => $r->in,
        'pais_id' => $r->pais,
        'ciudad' => $r->ciudad,
        'nacionalidad' => $r->nacionalidad,
        'idiomas' => json_encode($r->idiomas),
        'cv' => $r->cv,
        'descripcion' => $r->descripcion
      ]);
    }

    MemberCat::create([
      'user_id' => $user->id,
      'categoria_id' => 4,
    ]);


    Valoracion::create([
      'user_id' => $user->id,
      'programa_id' => 0,
      'area' => $r->area1,
      'porcentaje' => $r->area1v
    ]);

    if ($r->area2 !== null) {
      Valoracion::create([
        'user_id' => $user->id,
        'programa_id' => 0,
        'area' => $r->area2,
        'porcentaje' => $r->area2v
      ]);
    }
    if ($r->area3 !== null) {
      Valoracion::create([
        'user_id' => $user->id,
        'programa_id' => 0,
        'area' => $r->area3,
        'porcentaje' => $r->area3v
      ]);
    }
    if ($r->area4 !== null) {
      Valoracion::create([
        'user_id' => $user->id,
        'programa_id' => 0,
        'area' => $r->area4,
        'porcentaje' => $r->area4v
      ]);
    }
    if ($r->area5 !== null) {
      Valoracion::create([
        'user_id' => $user->id,
        'programa_id' => 0,
        'area' => $r->area5,
        'porcentaje' => $r->area5v
      ]);
    }

    $perfil->user;
    $perfil->pais;
    $perfil->user->categorias;
    foreach ($perfil->user->categorias as $key => $categoria) {
      $categoria->categoria;
    }
    return $perfil;
  }

  public function update($id){
    $empresa = Empresa::find($id);
  }
  public function delete($id){
    $empresa = Empresa::find($id);
    $empresa->delete();
  }
}
