<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrdemServico;



class OrdemServicoController extends Controller
{
    //

    public function index()
    {



        $ordensServico = auth()->user()
            ->ordensServico()
            ->with('servico')
            ->latest()
            ->paginate(10);

        $servicos = auth()->user()
            ->servicos()
            ->orderBy('nome')
            ->get();

        return view('layouts.services', compact('ordensServico', 'servicos'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'servico_id' => 'required|exists:servicos,id',
            'status' => 'required|in:aberta,em_andamento,aguardando,concluida,cancelada',

            'descricao' => 'required|string',
            'valor_total' => 'nullable|numeric',
            'observacoes' => 'nullable|string',



        ]);

        $validatedData['user_id'] = auth()->id();

        $validatedData['numero_os'] =
            (OrdemServico::max('numero_os') ?? 0) + 1;

        $validatedData['data_abertura'] = now();

        $validatedData['data_fechamento'] = null;

        OrdemServico::create($validatedData);


        return redirect()
            ->back()
            ->with('success', 'Ordem de serviço cadastrada com sucesso!');
    }
}
