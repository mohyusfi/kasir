<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-table :thead="['id', 'name', 'description', 'quantity', 'added at']">
        <tr>
            <td>1</td>
            <td>Sabun Lux</td>
            <td>Sabun cuci badan</td>
            <td>12</td>
            <td>2 hours ago</td>
        </tr>
    </x-table>

    <x-daisy-modal>
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
                'search' => [
                    'placeholder' => 'Enter Category',
                    'default' => '',
                ]
            ]"
            method="createProduct"
        />
    </x-daisy-modal>
</div>