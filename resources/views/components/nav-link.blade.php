@props([
    'active' => false,
    'href' => '#'
])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            ($active
                ? 'bg-blue-600 text-white shadow-md'
                : 'text-slate-600 hover:bg-slate-100 hover:text-blue-600')
            . ' flex items-center gap-3 mx-4 px-4 py-3 rounded-xl font-medium transition-all duration-200'
    ]) }}>

    {{ $slot }}

</a>