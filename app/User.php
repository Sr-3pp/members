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
        'email', 'password', 'folio', 'tipo',
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
      return $this->hasOne('App\Perfil');
    }
    public function empresa(){
      return $this->hasOne('App\Empresa');
    }

    public function categorias(){
      return $this->hasMany('App\MemberCat');
    }

    public function valoracion(){
      return $this->hasMany('App\Valoracion');
    }

    public function scopeSearch($query, $name){
      return $query->where('folio', "LIKE", "%$name%");
    }

}
