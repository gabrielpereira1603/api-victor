<x-modal :name="'createAlert'">
    <div class="p-6 space-y-6">
        <div class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
            <x-add-notification-icon width="24px" height="24px" color="currentColor" />
            <h2 class="text-xl font-semibold">
                Adicionar novo alerta
            </h2>
        </div>

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


        <x-input-label for="image_path" value="Cadastrar Foto do Alerta"></x-input-label>
        <form class="flex flex-col" wire:submit.prevent="save" enctype="multipart/form-data">
            @error('form.image_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <!-- Input de Upload -->
            <div class="w-full mb-2">
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-6 transition hover:bg-gray-50 dark:hover:bg-gray-800">
                    <label for="upload_image_path" class="cursor-pointer flex flex-col items-center justify-center">
                        <div class="text-gray-500 dark:text-gray-400 text-center">
                            <svg class="w-8 h-8 mx-auto" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 16v-4a4 4 0 10-8 0v4m12 0a8 8 0 01-16 0v-4a8 8 0 0116 0v4z"></path>
                            </svg>
                            <p class="mt-2">Clique aqui para adicionar fotos</p>
                        </div>
                    </label>
                    <input id="upload_image_path" type="file" wire:model="form.image_path"  class="hidden">
                </div>
            </div>

            <div wire:loading wire:target="form.image_path" class="relative mt-4 w-full">
                <div class="w-full bg-gray-300 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 100%"></div>
                </div>
                <p class="text-gray-500 text-sm mt-1">Carregando imagens...</p>
            </div>

            @if ($form->image_path)
                <div class="flex flex-col items-center gap-4">
                    @error('form.image_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    <div class="relative">
                        <img src="{{ $form->image_path->temporaryUrl() }}"
                             alt="Foto selecionada"
                             class="w-36 h-36 rounded-lg shadow-md">
                        <button type="button" wire:click="clearPhoto"
                                class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <span class="flex items-center justify-center gap-1">
                        <strong class="text-gray-600 dark:text-gray-400">
                            Imagem Selecionada:
                        </strong>
                        <p class="text-blue-300 underline cursor-pointer">
                            {{ $form->image_path->getClientOriginalName() }}
                        </p>
                    </span>
                </div>
            @endif

            <div>
                <x-input-label for="start_date" value="Data de Início" />
                <input
                    id="start_date"
                    type="text"
                    class="w-full mt-2 p-2 border border-gray-300 rounded"
                    wire:model.defer="form.start_date"
                />

                <x-input-label for="end_date" value="Data de Fim" class="mt-4" />
                <input
                    id="end_date"
                    type="text"
                    class="w-full mt-2 p-2 border border-gray-300 rounded"
                    wire:model.defer="form.end_date"
                />
            </div>

            <div class="flex gap-2 justify-end mt-6">
                <x-cancel-button @click="$dispatch('close-modal', 'createAlert')" class="ml-4">
                    Fechar
                </x-cancel-button>

                <x-primary-button wire:click="save">
                    Salvar
                </x-primary-button>
            </div>
        </form>
    </div>



</x-modal>

