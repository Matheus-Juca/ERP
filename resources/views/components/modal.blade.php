@props([
'name'
])

<div
x-data="{open:false}"

@open-modal.window="if($event.detail=='{{ $name }}')open=true"

x-show="open"

class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"

x-transition>

<div
@click.outside="open=false"

class="bg-white rounded-2xl w-full max-w-xl p-8">

{{ $slot }}

</div>

</div>