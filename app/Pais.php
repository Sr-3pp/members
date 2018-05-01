<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = ['nombre', 'zona_id'];

    public function perfil(){
      return $this->hasMany('App\User');
    }
    public function participantes(){
      return $this->hasMany('App\Participantes');
    }
    public function zona(){
      return $this->belongsTo('App\Zona');
    }
    public function scopeSearch($query, $nombre){
      return $query->where('nombre', "LIKE", "%$nombre%");
    }
}
