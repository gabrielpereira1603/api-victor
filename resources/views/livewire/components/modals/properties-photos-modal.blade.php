<x-modal :name="'editPhotosModal' . $form->property->id" maxWidth="2xl" >
    <div class="p-6 space-y-2">
        <h2 class="flex items-center text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            <x-photos-icon color="text-blue-500" />
            Editar Fotos da Propriedade #{{ $form->property->id }}
        </h2>
        <x-input-label for="EditPhotos" value="Cadastrar Novas Fotos"></x-input-label>

        <div class="mt-2 mb-2">
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
        </div>

        <form class="flex flex-col" wire:submit.prevent="save" enctype="multipart/form-data">
            @error('form.photos') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <!-- Input de Upload -->
            <div class="w-full mb-2">
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-6 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                    <label for="file-upload-{{ $form->property->id }}" class="cursor-pointer flex flex-col items-center justify-center">
                        <div class="text-gray-500 dark:text-gray-400 text-center">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 16v-4a4 4 0 10-8 0v4m12 0a8 8 0 01-16 0v-4a8 8 0 0116 0v4z"></path>
                            </svg>
                            <p class="mt-2">Clique aqui para adicionar fotos</p>
                        </div>
                    </label>
                    <input id="file-upload-{{ $form->property->id }}" type="file" wire:model="form.photos" multiple class="hidden">
                </div>
            </div>

            <!-- Barra de Progresso -->
            <div wire:loading wire:target="form.photos" class="relative mt-4 w-full">
                <div class="w-full bg-gray-300 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
                </div>
                <p class="text-gray-500 text-sm mt-1">Carregando imagens...</p>
            </div>

            @if ($form->photos)
                <x-input-label for="selectedPhotos" value="Fotos Selecionadas:" class="mb-3 mt-3"></x-input-label>

                <div class="flex flex-wrap gap-4 mb-4">
                    @foreach ($form->photos as $index => $photo)
                        <div class="relative">
                            <img src="{{ $photo->temporaryUrl() }}" alt="Foto" class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-md">
                            <button type="button"
                                    wire:click="clearPreviewPhotos({{ $index }})"
                                    wire:confirm="Voçe deseja remover a foto selecionada?"
                                    class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md">
                                <span class="text-xs">X</span>
                            </button>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-row w-full gap-4">
                    <button
                        wire:click="clearPreviewPhotos()"
                        wire:loading.attr="disabled"
                        type="button"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded flex items-center justify-center flex-1">
                        <x-delete-icon width="16px" height="16px" color="white" />
                        Limpar Todas
                    </button>

                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded flex items-center justify-center flex-1 gap-1">
                        <x-save-icon width="16px" height="16px" color="white"/>
                        <span wire:loading.remove wire:target="save">Salvar</span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H4z"></path>
                            </svg>
                            Carregando...
                        </span>
                    </button>
                </div>
            @endif
        </form>
    </div>


    <div class="p-6 space-y-2">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Fotos já cadastradas</h2>
        @if (count($existingPhotos) > 0)
            <form class="flex flex-col">
                <x-input-label for="EditExistingPhotos" value="Editar fotos cadastradas"></x-input-label>
                <div class="flex flex-wrap gap-4 w-full mt-2 mb-5">
                    @foreach($existingPhotos as $photo)
                        <div class="relative">
                            <img src="{{ $photo['image_url'] }}" alt="Foto cadastrada" class="w-20 h-20 object-cover rounded-lg border border-gray-300 shadow-md">

                            <button type="button"
                                    wire:confirm="Voçe deseja remover a foto cadastrada?"
                                    wire:click="clearExistingPhoto({{ $photo['id'] }})"
                                    class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-md">
                                <span class="text-xs">X</span>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div class="flex items-center justify-center w-full mt-5">
                    <button
                        type="button"
                        wire:loading.attr="disabled"
                        wire:target="clearExistingPhoto"
                        wire:click="clearExistingPhoto"
                        class="w-full text-center bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded flex items-center justify-center gap-2">
                        <x-delete-icon width="16px" height="16px" color="white" />
                        <span wire:loading.remove wire:target="clearExistingPhoto">Limpar Todas Imagens Cadastradas</span>
                        <span wire:loading wire:target="clearExistingPhoto" class="flex items-center gap-2">
                            <svg class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-8 8v-8H4z"></path>
                            </svg>
                            Carregando...
                        </span>
                    </button>
                </div>

            </form>
        @else
            <p class="text-gray-700 dark:text-gray-300">Nenhuma foto cadastrada, clique acima para cadastras!</p>
        @endif
    </div>
</x-modal>
