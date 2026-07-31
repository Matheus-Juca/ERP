@props([
    'title',
    'icon',
    'open' => false,
])

<div
    x-data="{ open: @js($open) }"
    class="mx-4 mb-2"
>

    <button
        type="button"
        @click="open = !open"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-100 transition"
    >

        <div class="flex items-center gap-3">

            <i class="{{ $icon }} text-lg"></i>

            <span class="font-medium">
                {{ $title }}
            </span>

        </div>

        <i
            class="bx bx-chevron-right transition duration-300"
            :class="{ 'rotate-90': open }"
        ></i>

    </button>

    <div
        x-show="open"
        x-transition
        class="mt-2 ml-6 space-y-1"
    >

        {{ $slot }}

    </div>

</div>