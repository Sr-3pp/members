<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = ['nombre'];

    public function pais(){
      return $this->hasMany('App\Pais');
    }
}
