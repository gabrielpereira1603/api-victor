<x-modal :name="'editPhotosModal' . $property->id" maxWidth="2xl">
    <div class="p-6 space-y-6" x-data="photoManager()">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Editar Fotos da Propriedade</h2>
        <x-input-label for="EditPhotos" value="Cadastrar Novas Fotos"></x-input-label>
        <div class="flex justify-between items-center">
            <form class="flex flex-col" wire:submit.prevent="save" enctype="multipart/form-data">
                @csrf

                <div class="w-full">
                    <div class="bg-gray-100 border-2 border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-6 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                        <label for="photo" class="cursor-pointer w-full flex flex-col items-center justify-center text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                {{ __('Arraste ou clique para selecionar uma foto.') }}
                            </p>
                        </label>
                        <input type="file" id="photo" wire:model="form.photos" class="hidden" multiple>
                        @error('form.photos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if ($form->photos && is_array($form->photos))
                    <x-input-label for="selectedPhotos" value="Fotos Selecionadas:" class="mb-3 mt-3"></x-input-label>

                    <div class="flex flex-wrap space-x-4">
                        @foreach ($form->photos as $index => $photo)
                            <div class="relative">
                                <!-- Foto com bordas arredondadas e desfoque -->
                                <img src="{{ $photo->temporaryUrl() }}" alt="Foto" class="w-20 h-20 object-cover rounded-lg filter">

                                <!-- Botão para remover a foto -->
                                <button type="button" wire:click="removePhoto({{ $index }})" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center">
                                    <span class="text-xs">X</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                @endif
            </form>
        </div>
    </div>

</x-modal>
