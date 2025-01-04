<x-modal :name="'editPhotosModal' . $property->id" maxWidth="2xl">
    <div class="p-6 space-y-2">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Editar Fotos da Propriedade</h2>
        <x-input-label for="EditPhotos" value="Cadastrar Novas Fotos"></x-input-label>

        @if (session()->has('success'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition-opacity ease-in duration-1000"
                 x-transition:leave="transition-opacity ease-out duration-1000"
                 class="bg-green-500 text-white p-2 rounded mb-4 opacity-100">
                {{ session('success') }}
            </div>
        @elseif(session()->has('error'))
            <div x-data="{ show: true }"
                 x-show="show"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition-opacity ease-in duration-1000"
                 x-transition:leave="transition-opacity ease-out duration-1000"
                 class="bg-red-500 text-white p-2 rounded mb-4 opacity-100">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col space-y-2">
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
                                {{ __('Clique para selecionar uma foto.') }}
                            </p>
                        </label>
                        <input type="file" id="photo" wire:model="form.photos" class="hidden" multiple>
                        @error('form.photos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                @if ($form->photos && is_array($form->photos))
                    <x-input-label for="selectedPhotos" value="Fotos Selecionadas:" class="mb-3 mt-3"></x-input-label>

                    <div class="flex flex-wrap gap-4 w-full">
                        @foreach ($form->photos as $index => $photo)
                            <div class="relative">
                                <!-- Foto com bordas arredondadas e desfoque -->
                                <img src="{{ $photo->temporaryUrl() }}" alt="Foto" class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-md">

                                <!-- Botão para remover a foto -->
                                <button type="button" wire:click="clearPhotos({{ $index }})" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md">
                                    <span class="text-xs">X</span>
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end items-center gap-2 mt-4 w-full">
                        <button type="button" wire:click="clearPhotos" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded flex items-center">
                            <x-delete-icon width="16px" height="16px" color="white" />
                            <span>Limpar Todas</span>
                        </button>

                        <button type="submit" wire:click="save" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 gap-1 rounded flex items-center">
                            <x-save-icon widht="16px" height="16px" color="white"/>
                            <span>Salvar Fotos</span>
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <div class="p-6 space-y-2">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Fotos já cadastradas</h2>
        @if (count($existingPhotos) > 0)
            <form class="flex flex-col">
                <x-input-label for="EditExistingPhotos" value="Editar fotos cadastradas"></x-input-label>
                <div class="flex flex-wrap gap-4 w-full mt-2">
                    @foreach($existingPhotos as $photo)
                        <div class="relative">
                            <img src="{{ $photo['image_url'] }}" alt="Foto cadastrada" class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-md">

                            <!-- Botão para remover uma foto -->
                            <button type="button" wire:click="clearExistingPhoto({{ $photo['id'] }})" class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md">
                                <span class="text-xs">X</span>
                            </button>
                        </div>
                    @endforeach
                </div>

                <!-- Botão para limpar todas -->
                <div class="flex justify-end items-center gap-2 mt-4 w-full">
                    @if($confirmDelete)
                        <!-- Modal de confirmação -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <div class="bg-white p-6 rounded-lg shadow-md w-75">
                                <h3 class="text-lg font-semibold">Confirmar exclusão de toda(s) as foto(s)</h3>
                                <p class="mt-2">Você tem certeza que deseja excluir toda(s) as foto(s)?</p>
                                <div class="mt-4 flex justify-between">
                                    <button type="button" wire:click="clearExistingPhoto" class="flex items-center bg-red-600 text-white px-4 py-2 rounded-md">
                                        <x-delete-icon width="16px" height="16px" color="white" />
                                        Sim, excluir
                                    </button>
                                    <button type="button" wire:click="$set('confirmDelete', false)" class="flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-md">
                                        <x-cancel-icon width="16px" height="16px" color="white" />
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <button type="button" wire:click="clearExistingPhoto" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded flex items-center">
                            <x-delete-icon width="16px" height="16px" color="white" />
                            <span>Limpar Todas</span>
                        </button>
                    @endif
                </div>
            </form>
        @else
            <p class="text-gray-700 dark:text-gray-300">Nenhuma foto cadastrada.</p>
        @endif
    </div>

</x-modal>
