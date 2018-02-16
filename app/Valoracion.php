<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Valoracion extends Model
{
    protected $fillable = ['user_id', 'programa_id', 'area', 'porcentaje'];

    public function user(){
      return $this->hasOne('App\User');
    }
}
