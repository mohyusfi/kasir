@props(['thead'])

<div class="overflow-x-auto">
    <table class="table">
        <!-- head -->
        <thead>
            <tr>
                @foreach ($thead as $item)
                    <th class="font-semibold text-gray-900">{{ $item }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
