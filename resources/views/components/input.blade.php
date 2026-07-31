@props([
'label',
'name',
'type'=>'text'
])

<div>

<label class="block mb-2 text-sm font-semibold text-slate-700">

{{ $label }}

</label>

<input

name="{{ $name }}"

type="{{ $type }}"

{{ $attributes }}

class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">

</div>