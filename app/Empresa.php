<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
  protected $fillable = [
    "user_id",
    "name",
    "telefono",
    "rango",
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
    "cv",
    "descripcion",
    "status"
  ];

  public function pais(){
    return $this->belongsTo('App\Pais');
  }
  public function user(){
    return $this->belongsTo('App\User');
  }

    public function scopeSearch($query, $name){
      return $query->where('name', "LIKE", "%$name%");
    }

    public function programas(){
      return $this->hasMany('App\Programa');
    }
}
