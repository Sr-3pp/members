<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = [
      "user_id",
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
          if($key === 'name'){
            return $query->where('name', "LIKE", "%$name%");
          }else if($key === 'app_p'){
            return $query->where('apellido_p', "LIKE", "%$name%");
          }else if($key === 'app_m'){
            return $query->where('apellido_m', "LIKE", "%$name%");
          }
    }
}
