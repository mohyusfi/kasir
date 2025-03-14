<!-- Open the modal using ID.showModal() method -->
@props(['title', 'btnName', 'btnType'])

<button class="btn m-2 {{ $btnType }}" onclick="my_modal_5.showModal()">{{ $btnName ?? 'create' }}</button>
<dialog id="my_modal_5" class="modal modal-bottom sm:modal-middle">
  <div class="modal-box">
    <h3 class="text-lg font-bold">{{ $title ?? 'Daisy Modal' }}</h3>
    {{ $slot }}
    <div class="modal-action">
      <form method="dialog">
        <!-- if there is a button in form, it will close the modal -->
        <button class="btn">close</button>
      </form>
    </div>
  </div>
</dialog>