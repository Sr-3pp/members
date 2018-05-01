<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participantes extends Model
{
    protected $fillable = ['programa_id', 'user_id', 'nombre', 'folio', 'pais_id'];

    public function user(){
      return $this->belongsTo('App\User');
    }
    public function empresa(){
      return $this->hasOne('App\Empresa');
    }
    public function programa(){
      return $this->belongsTo('App\Programa');
    }

    public function pais(){
      return $this->belongsTo('App\Pais');
    }
}
