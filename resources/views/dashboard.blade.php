<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-gray-900">
                    <x-table :thead="['id', 'name', 'description', 'color']">
                        <tr>
                            <td>1</td>
                            <td>Moh Yusfi Lakhafidun</td>
                            <td>
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Ipsum, molestias! Odit
                                recusandae deleniti nulla unde ab reiciendis quo hic libero suscipit id earum veritatis
                                ratione, doloremque velit ea, delectus error?
                            </td>
                            <td>Blue</td>
                        </tr>
                    </x-table>

                    <div>

                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-10 text-gray-900">
                    <h1 class="font-black">Make Transaction</h1>
                    <form action="" method="post" class="grid gap-3 mt-4">
                        <div>
                            <label for="id">ID Product</label>
                            <br>
                            <input class="rounded-lg" type="text" name="id" id="id" placeholder="Product ID">
                        </div>
                        <div>
                            <label for="quantity">Quantity</label>
                            <br>
                            <input class="rounded-lg" type="text" name="quantity" id="quantity" placeholder="Quantity Product">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Confirmation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
