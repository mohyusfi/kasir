@props(['message', 'type'])


<div role="alert" class="alert {{$type}} rounded-md mb-4 border-gray-500 border-x-0 border-t-0 border-b-4 opacity-0 animate-fade-in">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <span>{{ $type == "error" ? "Kesalahan! " : "" }} {{ $message }}</span>
</div>