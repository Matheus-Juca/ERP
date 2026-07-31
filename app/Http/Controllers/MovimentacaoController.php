<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Movimentacao;
use Illuminate\Http\Request;

class MovimentacaoController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        if (! $user) {
            abort(401);
        }

        $movimentacoes = Movimentacao::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        //calculos das movimentações

        $receitas = Movimentacao::where('user_id', $user->id)
            ->where('tipo', 'receita')
            ->sum('valor');

        $despesas = Movimentacao::where('user_id', $user->id)
            ->where('tipo', 'despesa')
            ->sum('valor');

        $saldo = $receitas - $despesas;


        //grafico
        $grafico = $this->graficoFluxoCaixa();

        return view('financeiro.dashboard-fin', [
            'labels' => $grafico['labels'],
            'receitasGrafico' => $grafico['receitasGrafico'],
            'despesasGrafico' => $grafico['despesasGrafico'],
            'saldoGrafico' => $grafico['saldoGrafico'],

            'movimentacoes' => $movimentacoes,
            'receitas' => $receitas,
            'despesas' => $despesas,
            'saldo' => $saldo,
        ]);
    }

    public function graficoFluxoCaixa()
    {

        $user = Auth::user();

        $movimentacoesGrafico = Movimentacao::where('user_id', $user->id)
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at')
            ->get();

        $labels = [];
        $receitasGrafico = [];
        $despesasGrafico = [];
        $saldoGrafico = [];

        $saldoAtual = 0;

        foreach ($movimentacoesGrafico as $movimentacao) {

            // Data do eixo X
            $labels[] = $movimentacao->created_at->format('d/m');

            if ($movimentacao->tipo == 'receita') {

                $receitasGrafico[] = $movimentacao->valor;
                $despesasGrafico[] = 0;

                $saldoAtual += $movimentacao->valor;
            } else {

                $receitasGrafico[] = 0;
                $despesasGrafico[] = $movimentacao->valor;

                $saldoAtual -= $movimentacao->valor;
            }

            // Saldo acumulado
            $saldoGrafico[] = $saldoAtual;
        }

        return [
            'labels' => $labels,
            'receitasGrafico' => $receitasGrafico,
            'despesasGrafico' => $despesasGrafico,
            'saldoGrafico' => $saldoGrafico,
        ];
    }

    public function store(Request $request)
    {
        // Implementation for storing movimentacao
        $dados = $request->validate([
            'tipo' => 'required|in:receita,despesa',
            'descricao' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0',
            'data_movimentacao' => 'date',
        ]);

        $request->user()->movimentacoes()->create($dados);

        return redirect()->back()->with('success', 'Movimentação criada com sucesso!');
    }
}
