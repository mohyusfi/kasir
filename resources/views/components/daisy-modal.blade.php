<!-- Open the modal using ID.showModal() method -->
@props(['title' => 'insert product', 'btnName' => 'create', 'btnType'])

<div wire:ignore.self>
    <button class="btn m-2 {{ $btnType }}" onclick="{{ $btnName }}.showModal()">{{ $btnName }}</button>
    <dialog id="{{ $btnName }}" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
      <div class="modal-box">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        {{ $slot }}
        <div class="modal-action">
          <form method="dialog">
            <!-- if there is a button in form, it will close the modal -->
            <button class="btn">close</button>
          </form>
        </div>
      </div>
    </dialog>
</div>
{{-- {{ $attributes->thatStartWith('wire:key') }} --}}