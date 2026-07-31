<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servico;
use App\Models\User;
use App\Models\OrdemServico;

class ServicoController extends Controller
{
    public function index()
    {

        $osEmAberto = OrdemServico::where('user_id', auth()->id())
        ->where('status', 'aberta')
        ->count();

        $osFinalizadas = OrdemServico::where('user_id', auth()->id())
        ->where('status', 'concluida')
        ->count();


        $qtdServicos = Servico::where('user_id', auth()->id())
        ->where('id', 'id')
        ->count();

        $servicos = auth()->user()
            ->servicos()
            ->latest()
            ->paginate(10);

        $ordensServico = OrdemServico::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('layouts.services', compact(
            'servicos',
            'ordensServico', 
            'osEmAberto', 'osFinalizadas', 'qtdServicos'
        ));
    }

        

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'categoria' => 'nullable|string|max:255',
            'preco' => 'required|numeric|min:0',
        ]);

        $validatedData['user_id'] = auth()->id();
        $validatedData['ativo'] = true;

        Servico::create($validatedData);

        return redirect()
            ->back()
            ->with('success', 'Serviço cadastrado com sucesso!');
    }
}
