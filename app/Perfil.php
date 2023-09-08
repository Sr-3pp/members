<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
      "user_id",
      "full_name",
      "name",
      "apellido_p",
      "apellido_m",
      "telefono",
      "rango",
      "celular",
      "website",
      "foto",
      "fb",
      "tw",
      "in",
      "programas",
      "pais_id",
      "ciudad",
      "nacionalidad",
      "idiomas",
      "educacion",
      "resumen",
      "status"
    ];

    public function pais(){
      return $this->belongsTo('App\Pais');
    }
    public function user(){
      return $this->belongsTo('App\User');
    }


    public function scopeSearch($query, $name, $key){
            return $query
              ->where('name', "LIKE", "%$name%")
              ->orWhere('apellido_p', "LIKE", "%$name%")
              ->orWhere('apellido_m', "LIKE", "%$name%")
              ->orWhere('full_name', "LIKE", "%$name%")
              ->with('user.categorias.categoria')
              ->with('pais');
    }
}
