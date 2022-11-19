<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    protected $table = 'participante';

    protected $primaryKey = 'participante_id';

    protected $fillable = ['nome','matricula','turma_id'];

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id', 'turma_id');
    }
}
