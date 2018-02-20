<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'folio', 'apellido_p', 'apellido_m', 'tipo', 'rango', 'categoria_id', 'perfil_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function perfil(){
      return $this->belongsTo('App\Perfil');
    }

    public function categoria(){
      return $this->belongsTo('App\Categoria');
    }

    public function valoracion(){
      return $this->belongsTo('App\Valoracion');
    }

    public function scopeSearch($query, $name, $categoria){
      return $query->where('name', "LIKE", "%$name%")->where('categoria_id',$categoria);
    }
}
