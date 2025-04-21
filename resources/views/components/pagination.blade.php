<div class="join grid grid-cols-2">
    <button
        class="join-item btn btn-outline"
        x-bind:disabled="$wire.currentPage == 1"
        wire:click='previousPage()'>Previous page</button>
    <button
    x-bind:disabled="$wire.maxPage === $wire.currentPage"
        class="join-item btn btn-outline"
        wire:click='nextPage()'>Next</button>
</div>