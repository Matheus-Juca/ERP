<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estoque;
use Illuminate\Support\Facades\Auth;

class EstoqueController extends Controller
{
    public function index(){

        $totalItensEstoque = Estoque::where('user_id', auth()->id())
        ->count();
        
    $categorias = Estoque::where('user_id', auth()->id())
    ->get()
    ->groupBy('categoria');

    $labelsCategoria = [
    'Equipamentos',
    'Insumos',
    'Outros'
];

$valoresCategoria = [
    0,
    0,
    0
];

$itens = Estoque::where('user_id', auth()->id())->get();
  
foreach ($itens as $item) {

    $valorTotal = $item->valor_item * $item->quantidade_atual;

    switch ($item->categoria) {

        case 'equipamentos':
            $valoresCategoria[0] += $valorTotal;
            break;

        case 'insumos':
            $valoresCategoria[1] += $valorTotal;
            break;

        default:
            $valoresCategoria[2] += $valorTotal;
            break;
    }
}


        
        return view('layouts.estoque', compact('totalItensEstoque', 'labelsCategoria', 'valoresCategoria' ));
    }





    public function store(Request $request){

        $validatedData = $request->validate([
            'nome_item' => 'required|string|max:255',
            'quantidade_atual' => 'required|numeric|min:0',
            'valor_item' => 'required|numeric|min:0',
    
            'unidade' => 'nullable|numeric|min:1', 
            'estoque_minimo' => 'nullable|numeric|min:0',
            'categoria' => 'required|string|max:255',
            'proxima_reposicao' => 'nullable|date|min:0'

        ]);

        $validatedData['user_id'] = auth()->id();

        Estoque::create($validatedData);

        return redirect()
        ->back()
        ->with('sucess', 'Item do estoque cadastrado com sucesso');
    }
}
