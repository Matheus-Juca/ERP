<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemServico extends Model
{
    protected $table = 'ordens_de_servico';

    protected $fillable = [
        'user_id',
        'servico_id',
        'numero_os',
        'status',
        'data_abertura',
        'data_fechamento',
        'descricao',
        'valor_total',
        'observacoes',
    ];

    protected function casts(): array
{
    return [
        'data_abertura' => 'date',
        'data_fechamento' => 'date',
    ];
}
}
