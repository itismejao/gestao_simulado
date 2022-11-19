<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
  use \Illuminate\Notifications\Notifiable;

    protected $table = 'usuario';

    protected $primaryKey = 'usuario_id';

    protected $fillable = [
        'nome','cpf','senha','email', 'tipo_acesso_id'
    ];
    
    public function getAuthPassword()
    {
      return $this->senha;
    }
    // public function setPasswordAttribute($password){
    //     $this->attributes['senha'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    // }

}
