<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $table = 'turma';

    protected $primaryKey = 'turma_id';

    protected $fillable = ['nome_turma','ano','curso_id'];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id', 'curso_id');
    }

    public function participante()
    {
        return $this->hasMany(Participante::class, 'turma_id', 'turma_id');
    }
}
