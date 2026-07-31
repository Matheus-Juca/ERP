@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Serviços')

@section('content')

<div class="space-y-8" x-data="{modal:null}">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>

            <h2 class="text-3xl font-bold text-slate-800">
                Gestão de serviços
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Acompanhe seu fluxo de serviços e gerencie suas operações de forma eficiente.
            </p>

        </div>

    </div>

    <div class="flex flex-wrap gap-3">

        {{-- Criar serviço --}}
        <button
            type="button"
            class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-emerald-700 hover:shadow-lg"
            @click="modal='servico'">

            <i class='bx bx-plus-circle text-xl'></i>

            Registrar Serviço

        </button>

        {{-- Registrar ordem de serviço --}}

        <button
        type="button"
        class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-lg"
        @click="modal='ordem-servico'">
        
        <i class='bx bx-minus-circle text-xl'></i>
        
        Registrar Ordem de Serviço
        
    </button>
    
    
    
    
</div>

<section class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
    
    {{-- Serviçoes --}}
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
        
        <div class="flex items-center justify-between">
            
            
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Quantidade de Serviços cadastradados
                </p>
                <h2 class="mt-2 text-3xl font-bold text-emerald-600">
                    {{$servicos->count()}}
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
    
    {{-- Quantidade de Ordem de Serviços fechadas --}}
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
        
        <div class="flex items-center justify-between">
            
            <div>
                <p class="text-sm font-medium text-slate-500">
                    O.S encerradas
                </p>
                
                <h2 class="mt-2 text-4xl font-bold text-red-600">
                    {{ $osFinalizadas }}
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
    
    {{-- O.S em aberto --}}
    <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200">
        
        <div class="flex items-center justify-between">
            
            <div>
                <p class="text-sm font-medium text-slate-500">
                    O.S em aberto
                </p>
                
                <h2 class="mt-2 text-4xl font-bold text-blue-600">
                    {{ $osEmAberto }}
                    
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
        <div class="rounded-2xl bg-white border border-slate-200 shadow-sm p-2">
        
        <p class="text-sm font-medium text-slate-500">
            Controle de O.S
        </p>
        
        <div class="mt-6 h-40">
            <canvas id="graficoOs"></canvas>
        </div>
        
        </div>

</section>

{{-- Últimas O.S --}}

    <section class="rounded-2xl bg-white border border-slate-100 shadow-sm">

        <div class="border-b border-slate-200 p-6">

            <h3 class="text-lg font-bold">
                Últimas ordens de Serviços
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-20">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Data
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Descrição
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status O.S
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tipo de O.S
                        </th>
                    </tr>

                </thead>

                <tbody>

                    @forelse ($ordensServico as $ordemServico)

                    <tr class="border-t hover:bg-slate-20">

                        <td class="px-6 py-4">
                            {{ $ordemServico->data_abertura->format('d/m/Y') }}
                        </td>

                        <td class="px-3 py-3">
                            
                            @foreach($servicos as $servico)
                                {{$servico->nome}}
    
                            @endforeach
                        </td>

                        <td class="px-6 py-4">
                            {{ $ordemServico->status }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $ordemServico->status }}
                        </td>

                        <td class="px-6 py-4">

                         {{ $ordemServico->descricao }} 
                        </td>



                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="py-8 text-center text-slate-500">

                            Nenhuma ordem de serviço cadastrada.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>
            <div class="border-t border-slate-200 p-4">
                {{ $ordensServico->links() }}
            </div>
        </div>

    </section>

    <div x-show="modal == 'servico'  " class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-50">

        <div class="bg-white p-6 rounded-xl">

            <form action="{{ route('servicos.store') }}" method="POST">

                @csrf

                <div class="flex items-start justify-between border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            Registrar Serviço
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Cadastre um novo serviço no sistema.
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
                        <label for="valor" class="block text-sm font-medium text-slate-700">Nome do serviço</label>
                        <input type="text" name="nome" id="nome" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="valor" class="block text-sm font-medium text-slate-700">Preço</label>
                        <input type="number" name="preco" id="preco" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">


                        <label for="categoria" class="mt-4 block text-sm font-medium text-slate-700">Categoria</label>
                        <select name="categoria" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="manutencao">Manutenção</option>
                            <option value="instalacao">Instalação</option>
                            <option value="outros">Outros</option>
                        </select>

                        <input
                            type="hidden"
                            name="tipo"
                            value="servico">
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






    <div x-show="modal == 'ordem-servico'  " class="inset-0 fixed bg-black flex items-center justify-center bg-opacity-50">

        <div class="bg-white p-6 rounded-xl">

            <form action="{{ route('ordens.store') }}" method="POST">

                @csrf

                <div class="flex items-start justify-between border-b border-slate-200 pb-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            Registrar O.S
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Cadastre uma nova ordem de serviço no sistema.
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

                        <label for="servico" class="mt-4 block text-sm font-medium text-slate-700">Serviço a ser feito:</label>

                        <select name="servico_id">

                            @foreach($servicos as $servico)

                            <option value="{{ $servico->id }}">
                                {{ $servico->nome }}
                            </option>

                            @endforeach

                        </select>


                        <label for="descricao" class="mt-4 block text-sm font-medium text-slate-700">Descrição</label>
                        <input type="text" name="descricao" id="descricao" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="valor" class="block text-sm font-medium text-slate-700">Valor total</label>
                        <input type="number" name="valor_total" id="valor" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">

                        <label for="observacoes" class="mt-4 block text-sm font-medium text-slate-700">Observações</label>
                        <input type="text" name="observacoes" id="descricao" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">



                        <label for="categoria" class="mt-4 block text-sm font-medium text-slate-700">Status OS</label>

                        <!--- começa a pegar a categoria da OS conforme está salvo no DB de serviço cadastrado---->
                        <select name="status" id="categoria" class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            
                            <option value="aberta">O.S em aberto</option>
                            <option value="em_andamento">O.S em andamento</option>

                            <option value="aguardando">O.S aguardando agente</option>
                            <option value="concluida">Finalizada</option>
                            <option value="cancelada">Ordem cancelada</option>
                        </select>

                        <input
                            type="hidden"
                            name="tipo"
                            value="ordem-servico">
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
                        Salvar O.S
                    </button>
                </div>

            </form>
        </div>


    </div>

</div>

<!---- Alterar campos a serem salvos no DB conforme está na migration atraves do "name" dos inputs e garantir o preenchimento de todos os campos do DB tanto OS
Quando serviço---->
<script src="https://cdn.jsdelivr.net/npm/chart.js"> </script>
<script>
    const abertas = {{ $osEmAberto }};
    const fechadas = {{ $osFinalizadas }};

const ctx = document.getElementById('graficoOs');

new Chart(ctx, {
    type: 'doughnut',

    data: {
        labels: [
            'Abertas',
            'Fechadas'
        ],

        datasets: [{
            data: [
                abertas,
                fechadas
            ],

            backgroundColor: [
                '#0b42f5',
                '#c52222'
            ]
        }]
    },

    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

@endsection