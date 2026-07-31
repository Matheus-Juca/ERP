@extends('layouts.app')

@section('title', 'Estoque')

@section('page-title', 'Estoque')

@section('content')

<div class="space-y-8" x-data="{modal:null}">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <h2 class="text-2xl font-bold text-slate-800">
                Fluxo de estoque
            </h2>
        </div>
    </div>

    <div class="flex flex-wrap gap-3">

        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-emerald-700 hover:shadow-lg"
            @click="modal='adicionar'"
        >

            <i class='bx bx-plus-circle text-xl'></i>

            Adicionar item ao estoque


        </button>


        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-lg"
            @click="modal='remover'"
        >

            <i class='bx bx-plus-circle text-xl'></i>

            Remover item do estoque


        </button>

    </div>

        

    <section class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">



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
                        +100% este mês
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
                        Quantidade de itens devolvidos
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-red-600">
                        0
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-semibold text-red-600">
                        0% este mês
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-red-100">
                    <i class='bx bx-trending-down text-3xl text-red-600'></i>
                </div>

            </div>

        </div>

            {{--- categorias cadastradas no estoque ---}}
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Quantiade de categorias
                    </p>

                    <h2 class="mt-2 text-3xl font-bold text-blue-600">
                        15
                    </h2>

                    <span class="mt-2 inline-flex rounded-full bg-blue-100 px-2 py-1 text-xs font-semibold text-blue-600">
                        +8%
                    </span>
                </div>

                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                    <i class='bx bx-wallet text-3xl text-blue-600'></i>
                </div>

            </div>

        </div>        

                {{-- Gráfico --}}
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-6">
        
        <h3 class="text-lg font-bold">
            Gerenciamento de estoque
        </h3>
        
        <div class="mt-6 h-40">
            <canvas id="graficoEs"></canvas>
        </div>
        
        </div>

    </section>

    {{--- ultimas retiradas ---}}


    <section class="rounded-2xl bg-white border border-slate-200 shadow-sm">

        <div class="border-b border-slate-200 p-6">

            <h3 class="text-lg font-bold">
                Últimas retiradas no estoque
            </h3>
        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-50">

                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Item retirado
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Quantidade retirada
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Custo das retiradas
                        </th>
                    </tr>
                </thead>

                <tbody>


                    {{--- @forelse ($ordensServico as $ordemServico)---}}

                    <tr class="border-t hover:bg-slate-50">
                        <td class="px-6 py-4">


                        </td>

                        <td class="px-6 py-4">


                        </td>

                        <td class="px-6 py-4">


                        </td>
                    </tr>
                    {{--- @empty ---}}
                    <tr>

                        <td colspan="4" class="py-8 text-center text-slate-500">

                            Nenhuma movimentação no estoque registrada

                        </td>

                    </tr>

                    {{---@endforelse---}}
                </tbody>


            </table>
        </div>
    </section>


    <div x-show="modal == 'adicionar'" class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-60">

        <div class="bg-white p-10 rounded-xl">

            <form action="{{ route('estoque.store') }}" method="POST">
                @csrf

                    <div class="flex items-start justify-between border-b border-slate-200 pb-4">

                        <div>
                            <h2 class="text-lg font-bold text-slate-800">
                                Atualize seu estoque
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">

                                Registre um item de seu estoque
                            </p>
                        </div>
                        <button
                        type="button"
                        @click="modal = null"
                        class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600">


                        <i class='bx bx-x text-2xl'> </i>

                    </button>

                    </div>

                <div class="mt-4">
                    <div class="mt-4">
                        <label for="nome_item" class="block text-sm font-medium text-slate-700">Nome do item</label>
                        <input type="text" name="nome_item" id="nome_item" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="quantidade_disponivel" class="mt-4 block text-sm font-medium text-slate-700">Quantidade disponível</label>
                        <input type="text" name="quantidade_atual" id="quantidade_disponivel" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="valor_item" class="mt-4 block text-sm font-medium text-slate-700">Valor do item</label>
                        <input type="text" name="valor_item" id="valor_item" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="estoque_minimo" class="mt-4 block text-sm font-medium text-slate-700">Estoque minímo para o item</label>
                        <input type="text" name="estoque_minimo" id="estoque_minimo" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Categoria do item</label>
                        <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="insumos">Insumos</option>
                            <option value="Equipamentos">Equipamentos</option>
                            <option value="outros">Outros</option>
                        </select>

                        <input
                            type="hidden"
                            name="tipo"
                            value="aEstoque">
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
                        Salvar Serviço
                    </button>

                </div>
            </form>
        </div>

    </div>




    <div x-show="modal == 'remover'" class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-60">

            <div class="bg-white p-10 rounded-xl">

                <form action="" method="">
                    @csrf

                        <div class="flex items-start justify-between border-b border-slate-200 pb-4">

                            <div>
                                <h2 class="text-lg font-bold text-slate-800">
                                    Remoção de item
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">

                                    Remova um item de seu estoque
                                </p>
                            </div>
                            <button
                            type="button"
                            @click="modal = null"
                            class="flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-red-50 hover:text-red-600">


                            <i class='bx bx-x text-2xl'> </i>

                        </button>

                        </div>

                    <div class="mt-4">
                        <div class="mt-4">
                            <label for="nome_item" class="block text-sm font-medium text-slate-700">Nome do item</label>
                            <input type="text" name="nome_item" id="nome_item" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                            <label for="quantidade_disponivel" class="mt-4 block text-sm font-medium text-slate-700">Quantidade disponível</label>
                            <input type="text" name="quantidade_disponivel" id="quantidade_disponivel" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                            <label for="valor_item" class="mt-4 block text-sm font-medium text-slate-700">Valor do item</label>
                            <input type="text" name="valor_item" id="valor_item" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                            <label for="estoque_minimo" class="mt-4 block text-sm font-medium text-slate-700">Estoque minímo para o item</label>
                            <input type="text" name="estoque_minimo" id="estoque_minimo" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                            <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Categoria do item</label>
                            <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="insumos">Insumos</option>
                                <option value="Equipamentos">Equipamentos</option>
                                <option value="outros">Outros</option>
                            </select>

                            <input
                                type="hidden"
                                name="tipo"
                                value="aEstoque">
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
                            Salvar Serviço
                        </button>
                        
                    </div>
                </form>
            </div>

        </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const categoria = {{ Js::from($labelsCategoria) }};
const valores = {{ Js::from($valoresCategoria) }};

const ctx = document.getElementById('graficoEs');

new Chart(ctx, {
    type: 'doughnut',

    data: {
        labels: categoria,

        datasets: [{
            label: 'Valor do Estoque',

            data: valores,

            backgroundColor: [
                '#2563eb', // Equipamentos
                '#10b981', // Insumos
                '#f59e0b'  // Outros
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

            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.label + ': R$ ' +
                            context.raw.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                    }
                }
            }
        }
    }
});
</script>
@endsection