<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Estoque;
use App\Models\Movimentacao;
use App\Models\OrdemServico;


class DashboardController extends Controller
{
    public function index(){

        $user = auth()->user();

        //OS em aberto 

        $osEmAberto = OrdemServico::where('user_id', $user->id)
        ->where('status', 'aberta')
        ->count();

        //calculos das movimentações


        $movimentacoes = Movimentacao::where('user_id', $user->id)
        ->latest()
        ->paginate(10);


        $receitas = Movimentacao::where('user_id', $user->id)
            ->where('tipo', 'receita')
            ->sum('valor');

        $despesas = Movimentacao::where('user_id', $user->id)
            ->where('tipo', 'despesa')
            ->sum('valor');

        $saldo = $receitas - $despesas;


        //itens em estoque 

        $totalItensEstoque = Estoque::where('user_id', $user->id)
        ->count();

        return view('dashboard', compact(
        'totalItensEstoque', 
        'despesas',
        'saldo', 
        'receitas',
        'osEmAberto',
        'movimentacoes' ));

    }
}
