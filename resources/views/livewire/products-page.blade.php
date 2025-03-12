<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- <x-table :thead="['id', 'name', 'description', 'quantity', 'added at']">
        <tr>
            <td>1</td>
            <td>Sabun Lux</td>
            <td>Sabun cuci badan</td>
            <td>12</td>
            <td>2 hours ago</td>
        </tr>
    </x-table> --}}

    {{-- <livewire:search-option/> --}}

    <livewire:form-input
        :fields="[
            'name' => [
                'directive' => 'wire:model.live=input.name',
                'placeholder' => 'Lux'
            ],
            'description' => [
                'directive' => 'wire:model.live=input.description',
                'placeholder' => 'Lux Adalah sabun mandi'
            ],
            'price' => [
                'directive' => 'wire:model.live=input.price',
                'placeholder' => '200000'
            ],
            'quantity' => [
                'directive' => 'wire:model.live=input.quantity',
                'placeholder' => '100'
            ],
            'search' => []
        ]"
        method="createProduct"
    />

    {{-- <x-daisy-modal title="Add New Product ?" btnName="add product">
        <!-- Open the modal using ID.showModal() method -->
        <div class="p-6 rounded-lg shadow-lg w-full max-w-md">
            <h6 class="text-2xl font-bold  mb-4">Form Input</h6>
            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="name" class="block font-medium">Name</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter name" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block font-medium">Description</label>
                    <textarea id="description" name="description" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter description" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="quantity" class="block font-medium">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter quantity" required>
                </div>
                <button type="submit" class="w-full bg-gray-600 text-white py-2 rounded-lg hover:bg-gray-700 transition">Submit</button>
            </form>
        </div>
    </x-daisy-modal> --}}
</div>