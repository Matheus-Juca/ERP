<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        ERP • @yield('title', 'Dashboard')
    </title>


    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">


    {{-- Icons --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
        rel="stylesheet">


    {{-- Alpine --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    {{-- Laravel Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100 text-slate-800 font-[Inter] antialiased">


    {{-- NAVBAR --}}
    <header class="bg-white border-b border-slate-200">

        <div class="max-w-7xl mx-auto px-6">

            <div class="h-16 flex items-center justify-between">


                {{-- Logo --}}
                <a href="{{ route('dashboard') }}"
                    class="text-xl font-black text-blue-600">

                    ERP

                </a>


                {{-- Menu --}}
                <nav class="hidden md:flex items-center gap-6">


                    <a href="{{ route('dashboard') }}"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600">

                        Dashboard

                    </a>


                    <a href="#"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600">

                        Clientes

                    </a>


                    <a href="{{ route('servicos') }}"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600">

                        Serviços

                    </a>


                    <a href="{{ route('estoque') }}"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600">

                        Estoque

                    </a>


                    <a href="{{ route('dashboard-fin') }}"
                        class="text-sm font-medium text-slate-600 hover:text-blue-600">

                        Financeiro

                    </a>


                </nav>



                {{-- Usuário --}}
                <div
                    x-data="{open:false}"
                    class="relative">


                    <button
                        @click="open=!open"
                        class="flex items-center gap-3">


                        <div
                            class="h-10 w-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">

                            {{ strtoupper(substr(auth()->user()->name ?? 'A',0,1)) }}

                        </div>


                        <i class="bx bx-chevron-down"></i>


                    </button>



                    <div
                        x-show="open"
                        @click.outside="open=false"
                        x-transition
                        style="display:none"

                        class="absolute right-0 mt-3 w-48 rounded-xl bg-white border border-slate-200 shadow-lg overflow-hidden">


                        <a href="#"
                            class="block px-4 py-3 hover:bg-slate-50">

                            Perfil

                        </a>


                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button
                                class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">

                                Sair

                            </button>


                        </form>


                    </div>


                </div>


            </div>

        </div>


    </header>




    {{-- CONTEÚDO --}}

    <main class="max-w-7xl mx-auto px-6 py-8">


        @hasSection('page-title')

            <div class="mb-6">

                <h1 class="text-2xl font-bold text-slate-800">

                    @yield('page-title')

                </h1>

            </div>

        @endif


        @yield('content')


    </main>




    {{-- FOOTER --}}

    <footer class="border-t border-slate-200 bg-white mt-10">

        <div class="max-w-7xl mx-auto px-6 py-5 text-sm text-slate-500 flex justify-between">


            <span>
                © {{ date('Y') }} ERP Negócios
            </span>


            <span>
                ERP
            </span>


        </div>

    </footer>


</body>

</html>