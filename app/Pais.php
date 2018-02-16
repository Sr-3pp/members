<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    protected $fillable = ['nombre'];

    public function user(){
      return $this->belongsTo('App\User');
    }
}
