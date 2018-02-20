<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
      "telefono",
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
      return $this->hasOne('App\Pais');
    }
    public function user(){
      return $this->hasOne('App\User');
    }
}
