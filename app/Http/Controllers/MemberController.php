<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Hash;
use Storage;
use App\Perfil;
use App\Valoracion;
use App\MemberCat;
use App\Empresa;


class MemberController extends Controller
{
    public function newMember(Request $r){

      $users = User::all();
      //$folio = count($users)+1;
      //$folio = '0000'.count($users)+1;
      $user= User::create([
        'folio' => $r->folio,
        'email' => $r->email,
        'tipo' => 0,
        'password' => Hash::make($r->password)
      ]);

      foreach (json_decode($r->categorias) as $key => $categoria) {
        MemberCat::create([
          'user_id' => $user->id,
          'categoria_id' => $categoria,
        ]);
      }

      if ($r->hasFile('file')) {
        $perfil = Perfil::create([
          'user_id' => $user->id,
          'name' => $r->nombre,
          'apellido_p' => $r->apellido_p,
          'apellido_m' => $r->apellido_m,
          'rango' => $r->membresia,
          'telefono' => $r->telefono,
          'celular' => $r->cel,
          'website' => $r->website,
          'foto' => $r->file->store('/users/'.$user->id.'/profile_pics'),
          'fb' => $r->fb,
          'tw' => $r->tw,
          'in' => $r->in,
          'pais_id' => $r->pais,
          'ciudad' => $r->ciudad,
          'nacionalidad' => $r->nacionalidad,
          'idiomas' => json_encode($r->idiomas),
          'educacion' => $r->educacion,
          'resumen' => $r->cv
        ]);
      }else{
        $perfil = Perfil::create([
          'user_id' => $user->id,
          'name' => $r->nombre,
          'apellido_p' => $r->apellido_p,
          'apellido_m' => $r->apellido_m,
          'rango' => $r->membresia,
          'telefono' => $r->telefono,
          'celular' => $r->cel,
          'website' => $r->website,
          'foto' => '/media/img/defaults/profile_1.png',
          'fb' => $r->fb,
          'tw' => $r->tw,
          'in' => $r->in,
          'pais_id' => $r->pais,
          'ciudad' => $r->ciudad,
          'nacionalidad' => $r->nacionalidad,
          'idiomas' => json_encode($r->idiomas),
          'educacion' => $r->educacion,
          'resumen' => $r->cv
        ]);
      }
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
      $perfil->user->valoracion;
      $perfil->pais;
      $perfil->user->categorias;
      foreach ($perfil->user->categorias as $key => $categoria) {
        $categoria->categoria;
      }
      return $perfil;
    }

    public function update($id){
        $user = User::find($id);

        return $user;
    }

    public function delete($id){
      $user = User::find($id);

      $memcats = MemberCat::where('user_id', $user->id)->get();
      $vals = Valoracion::where('user_id', $user->id)->get();

      foreach ($vals as $key => $val) {
        $val->delete();
      }

      foreach ($memcats as $key => $cat) {
        $cat->delete();
      }

      $user->delete();

      return 1;
    }

    public function status($id){
      $user = Perfil::where('user_id', $id)->first();
      if ($user) {
        if ($user->status === 0) {
          $user->status = 1;
        }else{
          $user->status = 0;
        }
        $user->save();
        $user->pais;
        $user->user->categorias;
        foreach ($user->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
        return $user;
      }else{
        $empresa = Empresa::where('user_id', $id)->first();

        if ($empresa->status === 0) {
          $empresa->status = 1;
        }else{
          $empresa->status = 0;
        }
        $empresa->save();
        $empresa->pais;
        $empresa->user->categorias;
        foreach ($empresa->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }
        return $empresa;
      }
    }
}
