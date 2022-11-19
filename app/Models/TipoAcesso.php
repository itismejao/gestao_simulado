<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAcesso extends Model
{
    use HasFactory;

    protected $table = 'tipo_acesso';

    protected $primaryKey = 'tipo_acesso_id';

    public $timestamps = false;
}
