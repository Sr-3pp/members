<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = ['nombre'];

    public function perfil(){
      return $this->hasMany('App\User');
    }
    public function zona(){
      return $this->belongsTo('App\Zona');
    }
    public function scopeSearch($query, $pais){
      return $query->where('nombre', "LIKE", "%$pais%");
    }
}
