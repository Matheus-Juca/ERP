<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    protected $table = 'servicos';

    protected $fillable = [
        'user_id',
        'nome',
        'descricao',
        'categoria',
        'preco',
        'ativo',
    ];

        public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ordensServico()
    {
        return $this->hasMany(OrdemServico::class);
    }
}
