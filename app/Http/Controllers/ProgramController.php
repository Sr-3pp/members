<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Programa;
use App\Valoracion;
use App\MemberCat;

class ProgramController extends Controller
{
    public function newPrograma(Request $r){
      $programa = Programa::create([
                    'nombre' => $r->nombre,
                    'duracion' => $r->duracion,
                    'foto' => '0',
                    'empresa_id' => $r->empresa,
                    'alcance' => $r->cv
                  ]);

      $programa->foto = $r->picture->store('/programas/'.$programa->id);
      $programa->save();

                  MemberCat::create([
                    'user_id' => $r->empresa,
                    'programa_id' => $programa->id,
                    'categoria_id' => 5,
                  ]);

      Valoracion::create([
        'user_id' => 0,
        'programa_id' => $programa->id,
        'area' => $r->area1,
        'porcentaje' => $r->area1v
      ]);

      if ($r->area2 !== null) {
        Valoracion::create([
          'user_id' => 0,
          'programa_id' => $programa->id,
          'area' => $r->area2,
          'porcentaje' => $r->area2v
        ]);
      }
      if ($r->area3 !== null) {
        Valoracion::create([
          'user_id' => 0,
          'programa_id' => $programa->id,
          'area' => $r->area3,
          'porcentaje' => $r->area3v
        ]);
      }
      if ($r->area4 !== null) {
        Valoracion::create([
          'user_id' => 0,
          'programa_id' => $programa->id,
          'area' => $r->area4,
          'porcentaje' => $r->area4v
        ]);
      }
      if ($r->area5 !== null) {
        Valoracion::create([
          'user_id' => 0,
          'programa_id' => $programa->id,
          'area' => $r->area5,
          'porcentaje' => $r->area5v
        ]);
      }
      $programa->empresa->pais;
        $programa->participantes;
        $programa->valoracion;
      return $programa;
    }

    public function update($id){
        $programa = Programa::find($id);
        $programa->empresa;
        $programa->user;
        $programa->valoracion;

        return $programa;
    }

    public function delete($id){
      $programa = Programa::find($id);
      $memcats = MemberCat::where('programa_id', $programa->id)->get();
      $vals = Valoracion::where('programa_id', $programa->id)->get();

      foreach ($vals as $key => $val) {
        $val->delete();
      }
      foreach ($memcats as $key => $cat) {
        $cat->delete();
      }

      $programa->delete();
      return 1;
    }

    public function status($id){
      $programa = Programa::find($id);

        if ($programa->status === 0) {
          $programa->status = 1;
        }else{
          $programa->status = 0;
        }

        $programa->save();
        $programa->empresa->user->categorias;
        $programa->empresa->pais;
        $programa->participantes;
        $programa->valoracion;

        foreach ($programa->empresa->user->categorias as $key => $categoria) {
          $categoria->categoria;
        }

        return $programa;

    }
}
