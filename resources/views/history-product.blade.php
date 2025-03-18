<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800  leading-tight">
            {{ __('History Transaction') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <livewire:history-transaction-page />
    </div>
</x-app-layout>
