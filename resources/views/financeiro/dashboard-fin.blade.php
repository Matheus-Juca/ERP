@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Financeiro')

@section('content')

<div class="space-y-8" x-data="{modal:null}">



    <p x-text="modal"></p>

    {{-- Cabeçalho --}}

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Indicadores Financeiros
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Acompanhe receitas, despesas e fluxo de caixa em tempo real.
            </p>

        </div>

    </div>

    {{-- Botões --}}

    <div class="flex flex-wrap gap-3">

        {{-- Registrar Receita --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-emerald-700 hover:shadow-lg"
            @click="modal='receita'">

            <i class='bx bx-plus-circle text-xl'></i>

            Registrar Receita

        </button>

        {{-- Registrar Despesa --}}

        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-lg"
            @click="modal='despesa'">

            <i class='bx bx-minus-circle text-xl'></i>

            Registrar Despesa

        </button>




    </div>

    {{-- Cards --}}
    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Receitas --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Receitas
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-emerald-600">
                        R${{number_format($receitas, 2, ',', '.')}}
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-600">
                        +12% este mês
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-emerald-100">
                    <i class='bx bx-trending-up text-3xl text-emerald-600'></i>
                </div>

            </div>

        </div>

        {{-- Despesas --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Despesas
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-red-600">
                        R${{number_format($despesas, 2, ',', '.')}}
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-600">
                        -4% este mês
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-100">
                    <i class='bx bx-trending-down text-3xl text-red-600'></i>
                </div>

            </div>

        </div>

        {{-- Lucro --}}
 

        {{-- Caixa --}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Saldo em Caixa
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-violet-600">
                        R${{number_format($saldo, 2, ',', '.')}}
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-violet-100 px-2 py-1 text-xs font-semibold text-violet-600">
                        Atual
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-violet-100">
                    <i class='bx bx-credit-card text-3xl text-violet-600'></i>
                </div>

            </div>

        </div>

    </section>

    {{-- Gráficos --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <div class="xl:col-span-5 rounded-2xl bg-white border border-slate-300 shadow-sm p-6">

            <div class="flex items-center justify-between">

                <h3 class="text-lg font-bold">
                    Fluxo de Caixa
                </h3>

                <button class="rounded-lg border px-4 py-2 text-sm hover:bg-slate-100">
                    Últimos 30 dias
                </button>

            </div>

            <div class="mt-6 h-80">
                <canvas id="fluxoCaixaChart"></canvas>
            </div>

        </div>


    </section>

    {{-- Tabela --}}
    <section class="rounded-2xl bg-white border border-slate-200 shadow-sm">

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

    {{-- Rodapé --}}
    <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">

        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">

            <h3 class="mb-5 text-lg font-bold">
                Contas a Pagar
            </h3>

            <div class="space-y-4">

                <div class="rounded-xl border p-4">

                    <h4 class="font-semibold">
                        Fornecedor XPTO
                    </h4>

                    <p class="text-sm text-slate-500">
                        Vence amanhã
                    </p>

                    <p class="mt-2 font-bold text-red-600">
                        R$ 1.250,00
                    </p>

                </div>

            </div>

        </div>

        <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">

            <h3 class="mb-5 text-lg font-bold">
                Contas a Receber
            </h3>

            <div class="space-y-4">

                <div class="rounded-xl border p-4">

                    <h4 class="font-semibold">
                        Cliente João
                    </h4>

                    <p class="text-sm text-slate-500">
                        Recebe hoje
                    </p>

                    <p class="mt-2 font-bold text-emerald-600">
                        R$ 2.480,00
                    </p>

                </div>

            </div>

        </div>

    </section>


    <div x-show="modal == 'receita'" class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-50">

        <div class="bg-white p-6 rounded-xl">
            <form action="{{ route('movimentacoes.store') }}" method="POST">
                @csrf

                <div class="flex items-start justify-between border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Registrar Receita
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Cadastre uma nova receita no sistema.
                        </p>
                    </div>

                    <button type="button"
                        @click="modal = null"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600" >

                        <i class='bx bx-x text-2xl'>
                            
                        </i>
                    </button>
                </div>
                <div class="mt-4">
                    <div class="mt-4">
                        <label for="valor" class="block text-sm font-medium text-slate-700">Valor</label>
                        <input type="number" name="valor" id="valor" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="categoria" class="mt-4 block text-sm font-medium text-slate-700">Categoria</label>
                        <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="venda">Venda</option>
                            <option value="servico">Serviço</option>
                            <option value="outros">Outros</option>
                        </select>

                        <input
                            type="hidden"
                            name="tipo"
                            value="receita">
                    </div>

                </div>
                <div class="mt-8 flex justify-end gap-3 border-t border-slate-200 pt-5">
                    <button
                        type="button"
                        @click="modal = null"
                        class="rounded-xl border border-slate-300 px-5 py-2 font-medium text-slate-700 hover:bg-slate-100">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-emerald-600 px-5 py-2 font-medium text-white hover:bg-emerald-700">
                        Salvar Receita
                    </button>
                </div>

        </div>

        </form>

    </div>

    {{-- Modal Despesa --}}



    <div x-show="modal == 'despesa'" class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-50">

        <div class="bg-white p-6 rounded-xl">
            <form action="{{ route('movimentacoes.store') }}" method="POST">
                @csrf

                <div class="flex items-start justify-between border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">
                            Registrar Despesa
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Cadastre uma nova despesa no sistema.
                        </p>
                    </div>

                    <button type="button"
                        @click="modal = null"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600">

                        <i class='bx bx-x text-2xl'></i>
                    </button>
                </div>
                <div class="mt-4">
                    <div class="mt-4">
                        <label for="valor" class="block text-sm font-medium text-slate-700">Valor</label>
                        <input type="number" name="valor" id="valor" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="categoria" class="mt-4 block text-sm font-medium text-slate-700">Categoria</label>
                        <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="conta essencial">Conta essencial</option>
                            <option value="manutencao">Manutenção</option>
                            <option value="outros">Outros</option>
                        </select>

                        <input
                            type="hidden"
                            name="tipo"
                            value="despesa">
                    </div>

                </div>
                <div class="mt-8 flex justify-end gap-3 border-t border-slate-200 pt-5">
                    <button
                        type="button"
                        @click="modal = null"
                        class="rounded-xl border border-slate-300 px-5 py-2 font-medium text-slate-700 hover:bg-slate-100">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="rounded-xl bg-emerald-600 px-5 py-2 font-medium text-white hover:bg-emerald-700">
                        Salvar despesa
                    </button>
                </div>

        </div>

        </form>

    </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>

<script>
const labels = {{ Js::from($labels) }};
const receitas = {{ Js::from($receitasGrafico) }};
const despesas = {{ Js::from($despesasGrafico) }};
const saldo = {{ Js::from($saldoGrafico) }};

const ctx = document.getElementById('fluxoCaixaChart');

new Chart(ctx, {
    type: 'line',

    data: {
        labels: labels,

        datasets: [

            {
                label: 'Receitas',
                data: receitas,
                borderColor: '#16a34a',
                backgroundColor: '#16a34a33',
                tension: 0.3
            },

            {
                label: 'Despesas',
                data: despesas,
                borderColor: '#dc2626',
                backgroundColor: '#dc262633',
                tension: 0.3
            },

            {
                label: 'Saldo',
                data: saldo,
                borderColor: '#2563eb',
                backgroundColor: '#2563eb33',
                tension: 0.3
            }

        ]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                position: 'top'
            }
        }
    }
});
</script>

@endsection