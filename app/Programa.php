<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $fillable = ['folio', 'nombre', 'duracion', 'foto', 'empresa_id', 'alcance'];

    public function empresa(){
      return $this->belongsTo('App\Empresa');
    }

    public function participantes(){
      return $this->hasMany('App\Participantes');
    }

    public function valoracion(){
      return $this->hasMany('App\Valoracion');
    }

    public function scopeSearch($query, $name){
      return $query->where('nombre', "LIKE", "%$name%");
    }

}
