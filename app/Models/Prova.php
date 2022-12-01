<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prova extends Model
{
    use HasFactory;

    protected $table = 'prova';

    protected $primaryKey = 'prova_id';

    protected $fillable = ['nome', 'data_aplicacao'];

    public function participanteProva()
    {
        return $this->hasMany(ParticipanteProva::class, 'prova_id', 'prova_id');
    }

}
