<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $fillable = ['folio', 'nombre', 'duracion', 'foto', 'user_id', 'alcance'];

    public function user(){
      return $this->hasMany('App\User');
    }
}
