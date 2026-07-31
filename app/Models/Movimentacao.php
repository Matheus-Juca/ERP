<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Movimentacao extends Model
{

    protected $table = 'movimentacoes';

    protected $fillable = [
        'tipo',
        'descricao',
        'categoria',
        'valor',
        'data_movimentacao'
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}

