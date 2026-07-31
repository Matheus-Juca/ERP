@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

<div class="space-y8 mb-8">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <h2 class="text-2xl font-bold text-slate-800 mb-4"> 
                Principais indicadores
            </h2>
        </div>
    </div>



    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4 mb-8">

 


            {{--- Quantidade de itens emprestados no momento ---}}
         <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Quantidade de itens em estoque
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-green-600">
                        {{$totalItensEstoque}}
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-600">
                        +4% este mês
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-100">
                    <i class='bx bx-trending-up text-3xl text-green-600'></i>
                </div>

            </div>

        </div>       

            {{--- Itens devolvidos ao estoque ---}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Saldo em caixa
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-sky-600">
                     R${{number_format($saldo, 2, ',', '.')}}
                    </h2> 

                    <span class="mt-2 inline-flex rounded-full bg-sky-100 px-2 py-1 text-xs font-semibold text-sky-600">
                        -4% este mês
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                    <i class='bx bx-wallet text-3xl text-sky-600'></i>
                </div>

               

            </div>

        </div>

            {{--- categorias cadastradas no estoque ---}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        O.S em aberto
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-blue-600">
                        {{$osEmAberto}}
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-600">
                        +8%
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                    <i class='bx bx-trending-up text-3xl text-blue-600'></i>
                </div>
            </div>

        </div>        

                {{-- Gráfico --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
        
        <p class="text-sm font-medium text-slate-500">
            Resumo financeiro
        </p>
        
        <div class="mt-6 h-40">
            <canvas id="graficoFinDash"></canvas>
        </div>
        
        </div>


    </section>

    <section class="rounded-2xl bg-white border border-slate-200 shadow-sm mt-8">

        <div class="border-b border-slate-200 p-6">

            <h3 class="text-lg font-bold">
                Últimas Movimentações
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Data
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Descrição
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Categoria
                        </th>

                        <th class="px-6 py-4 text-right text-sm font-semibold">
                            Valor
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($movimentacoes as $movimentacao)

                    <tr class="border-t hover:bg-slate-50">

                        <td class="px-6 py-4">
                            {{ $movimentacao->created_at->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $movimentacao->descricao }}
                        </td>

                        <td class="px-6 py-4">
                            {{ ucfirst($movimentacao->categoria) }}
                        </td>

                        <td class="px-6 py-4 text-right">

                            @if($movimentacao->tipo == 'receita')

                            <span class="font-semibold text-emerald-600">
                                + R$ {{ number_format($movimentacao->valor,2,',','.') }}
                            </span>

                            @else

                            <span class="font-semibold text-red-600">
                                - R$ {{ number_format($movimentacao->valor,2,',','.') }}
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="py-8 text-center text-slate-500">

                            Nenhuma movimentação cadastrada.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>
            <div class="border-t border-slate-200 p-4">
                {{ $movimentacoes->links() }}
            </div>
        </div>

    </section>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const receitas = {{ Js::from($receitas) }};
const despesas = {{ Js::from($despesas) }};
const saldo = {{ Js::from($saldo) }}

const ctx = document.getElementById('graficoFinDash');

new Chart(ctx, {
    type: 'doughnut',

    data: {
        labels:[
                'receitas',
                'despessas',
                'saldo'
            ],
        datasets: [{
            label: 'Receita',

            data: [receitas,
                  despesas,
                  saldo
            ],
            backgroundColor: [
                '#2563eb', // Receita
                '#cf1919', // despesa
                '#1ce095fa' // saldo
              
               
            ],

            borderWidth: 2,
            borderColor: '#fff'
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                position: 'bottom'
            },
        }
    }
});
</script>
@endsection