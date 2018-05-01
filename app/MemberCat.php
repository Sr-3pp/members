<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberCat extends Model
{
    protected $fillable = ['categoria_id', 'user_id', 'programa_id'];

    public function user(){
      return $this->belongsTo('App\User');
    }
    public function programa(){
      return $this->belongsTo('App\Programa');
    }
    public function categoria(){
      return $this->belongsTo('App\Categoria');
    }
}
