<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function getPerfil($folio){
      $user = User::where('folio', $folio)->first();
      return view('perfil', compact('user'));
    }

    public function test(){
      $user = User::where('id', 1)->first();
      return $user->perfil->pais;
    }
}
