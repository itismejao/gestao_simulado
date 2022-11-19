<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planilha extends Model
{
    use HasFactory;

    protected $table = 'planilha';

    protected $primaryKey = 'planilha_id';

    protected $fillable = ['nome_original', 'extensao','caminho','qtd_linhas','prova_id','success'];

    public function prova()
    {
        return $this->belongsTo(Prova::class, 'prova_id', 'prova_id');
    }
}
