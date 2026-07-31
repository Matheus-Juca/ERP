@props([
    'type' => 'button',
    'variant' => 'primary'
])

@php

$classes = match($variant){

'primary' => 'bg-blue-600 hover:bg-blue-700 text-white',

'secondary' => 'bg-slate-200 hover:bg-slate-300 text-slate-800',

'danger' => 'bg-red-600 hover:bg-red-700 text-white',

'success' => 'bg-green-600 hover:bg-green-700 text-white',

default => 'bg-blue-600 hover:bg-blue-700 text-white'

};

@endphp

<button
type="{{ $type }}"
{{ $attributes->merge([
'class'=>"px-5 py-2.5 rounded-xl font-semibold transition $classes"
]) }}>

{{ $slot }}

</button>