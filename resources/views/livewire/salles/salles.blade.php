
<div class="py-12">
    <div >
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                  <div class="flex">
                    <div>
                      <p class="text-sm">{{ session('message') }}</p>
                    </div>
                  </div>
                </div>
            @endif
            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Creer une salle</button>
            @if($isOpen)
                @include('livewire.salles.create')
            @endif
            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 w-20">No.</th>
                        <th class="px-4 py-2">Numero</th>
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Salles as $Salle)
                    <tr>
                        <td class="border px-4 py-2">{{ $Salle->id }}</td>
                        <td class="border px-4 py-2">{{ $Salle->numero }}</td>
                        <td class="border px-4 py-2">{{ $Salle->description }}</td>
                        <td class="border px-4 py-2">
                        <button wire:click="edit({{ $Salle->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editer</button>
                            <button wire:click="delete({{ $Salle->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Suprimer</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>