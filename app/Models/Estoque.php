<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

class Estoque extends Model
{

    protected $table = 'estoque';

    protected $fillable = [
        'user_id',
        'nome_item',
        'quantidade_atual',
        'valor_item',
        'unidade',
        'estoque_minimo',
        'categoria',
        'proxima_reposicao'


    ];

        public function user()
{
    return $this->belongsTo(User::class);
}
}
