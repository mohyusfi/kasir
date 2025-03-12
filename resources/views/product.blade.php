<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <livewire:products-page/>
    </div>
</x-app-layout>
