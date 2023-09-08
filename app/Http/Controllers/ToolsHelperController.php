<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Perfil;

class ToolsHelperController extends Controller
{
    public function buildFullName(){
        $perfils = Perfil::get();
        $full_names = [];
        foreach ($perfils as $key => $value) {
            //$value->full_name = $value->name.' '.$value->apellido_p.' '.$value->apellido_m;
            //$value->save();
            array_push($full_names, $value->full_name);
        }

        return $full_names;
    }
}
