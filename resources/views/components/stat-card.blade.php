@props([
'title',
'value',
'icon'
])

<div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">

<div class="flex justify-between items-center">

<div>

<p class="text-sm text-slate-500">

{{ $title }}

</p>

<h2 class="text-3xl font-bold mt-2">

{{ $value }}

</h2>

</div>

<div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center">

<i class="{{ $icon }} text-3xl text-blue-600"></i>

</div>

</div>

</div>