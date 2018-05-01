<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    protected $fillable = ['nombre'];

    public function scopeSearch($query, $idioma){
      return $query->where('nombre', "LIKE", "%$idioma%");
    }

}
