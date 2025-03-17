<!-- Open the modal using ID.showModal() method -->
@props(['title' => 'insert product', 'btnName' => 'create', 'btnType', 'key' => uniqid()])

<div wire:ignore.self>
    <button class="btn {{ $btnType }}" onclick="my_modal_{{ $key }}.showModal()">{{ $btnName }}</button>
    <dialog id="my_modal_{{ $key }}" data-theme="light" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
      <div class="modal-box">
        <h3 class="text-lg font-bold text-center">{{ ucwords($title) }}</h3>
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