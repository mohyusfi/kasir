@props(['thead', 'hasContent' => false])

<div class="overflow-x-auto">
    <table class="table">
        <!-- head -->
        <thead>
            <tr>
                @foreach ($thead as $item)
                    <th class="font-semibold text-gray-900" wire:key="{{ $item }}">{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if ($hasContent)
                {{ $slot }}
            @else
                <tr class="border-none">
                    <td colspan="{{ count($thead) }}">
                        <h1 class="text-center text-xl">No Product</h1>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
