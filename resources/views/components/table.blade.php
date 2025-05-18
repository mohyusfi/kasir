@props(['thead', 'hasContent' => false, 'whenEmpty' => 'NO Product', 'center' => ''])

<div class="overflow-x-auto">
    <table class="table border-b-2 border-gray-500">
        <!-- head -->
        <thead>
            <tr>
                @foreach ($thead as $item)
                    <th class="font-semibold {{ $center ?? ''}} text-gray-900" wire:key="{{ $item }}">{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if ($hasContent)
                {{ $slot }}
            @else
                <tr class="border-none">
                    <td colspan="{{ count($thead) }}">
                        <h1 class="text-center text-xl">{{ $whenEmpty }}</h1>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
