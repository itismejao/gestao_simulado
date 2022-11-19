<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipanteProva extends Model
{
    use HasFactory;

    protected $table = 'participante_prova';

    protected $fillable = ['prova_id', 'participante_id'];

    public function prova()
    {
        return $this->belongsTo(Prova::class, 'prova_id', 'prova_id');
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class, 'participante_id', 'participante_id');
    }
}
