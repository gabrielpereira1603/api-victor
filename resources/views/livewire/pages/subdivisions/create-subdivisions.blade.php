<x-modal :name="'createBlocks'" maxWidth="2xl">
    <div class="p-6 space-y-6">
        <!-- Header do Modal -->
        <div class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
            <x-config-icon width="24px" height="24px" color="currentColor" />
            <h2 class="text-xl font-semibold">
                Cadastrar Quarteirão
            </h2>
        </div>

        <div class="mt-1 mb-1">
            @if (session()->has('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('error'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="bg-red-500 text-white p-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div>
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-300 mb-2">
                Quarteirões Cadastrados
            </h3>
            @if ($this->form->blocks->isEmpty())
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Nenhum quarteirão cadastrado ainda.
                </p>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($this->form->blocks as $block)
                        <li class="py-2 flex items-center justify-between">
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $block->name }}
                            </span>
                            <div class="flex items-center justify-end gap-x-4">
                                <button
                                    wire:click="editTypeProperty({{ $block->id }})"
                                    class="text-blue-600 dark:text-blue-400 text-sm hover:underline"
                                >
                                    <x-edit-icon width="14px" height="14px" color="currentColor"/>
                                </button>
                                <button
                                    wire:click="deleteTypeProperty({{ $block->id }})"
                                    wire:confirm="Você deseja remover o quarteirão cadastrado?"
                                    class="text-red-600 dark:text-red-400 text-sm hover:underline"
                                >
                                    <x-delete-icon width="14px" height="14px" color="currentColor"/>
                                </button>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        @if ($showInput)
            <x-secondary-button
                wire:click="toggleInput"
                class="w-full border text-red-500 border-red-500 bg-transparent flex justify-center items-center">
                <x-cancel-icon width="16px" height="16px" color="currentColor"/>
                Limpar Input
            </x-secondary-button>
        @else
            <x-primary-button
                wire:click="toggleInput"
                class="w-full flex justify-center items-center">
                <x-add-icon width="16px" height="16px" color="currentColor"/>
                Adicionar novo quarteirão
            </x-primary-button>
        @endif

        <!-- Formulário de Criação/Edição -->
        @if ($showInput)
            <form wire:submit.prevent="{{ $editingId ? 'update' : 'save' }}" class="space-y-4">
                <!-- Nome e Código -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="name" value="Nome do Quarteirão*" />
                        @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <x-text-input type="text" name="name" wire:model.defer="form.name" id="name" class="w-full" />
                    </div>
                    <div>
                        <x-input-label for="code" value="Código*" />
                        @error('form.code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <x-text-input type="text" name="code" wire:model.defer="form.code" id="code" class="w-full" />
                    </div>
                </div>

                <!-- Coordenadas -->
                <div>
                    <x-input-label value="Coordenadas*" />
                    <x-primary-button type="button" wire:click="addCoordinate"
                                      class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                        <x-add-icon width="20px" height="20px" color="currentColor"/>
                        Adicionar Coordenada
                    </x-primary-button>

                    <div class="mt-4 space-y-2">
                        @foreach ($form->coordinates as $index => $coordinate)
                            <div class="flex items-center gap-2">
                                <x-text-input type="text" wire:model="form.coordinates.{{ $index }}"
                                              placeholder="Ex: -23.5505, -46.6333"
                                              class="w-full" />
                                <button type="button" wire:click="removeCoordinate({{ $index }})"
                                        class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">
                                    Remover
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Status e Área -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div>
                        <x-input-label for="status" value="Status*" />
                        @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <select name="status" id="status" wire:model.defer="form.status" class="w-full border-gray-300 rounded-md shadow-sm">
                            <option value="active">Ativo</option>
                            <option value="inactive">Inativo</option>
                        </select>
                    </div>

                    <div>
                        <x-input-label for="area" value="Área (m²)" />
                        @error('form.area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <x-text-input type="number" step="0.01" name="area" wire:model.defer="form.area" id="area" class="w-full" />
                    </div>

                    <div>
                        <x-input-label for="color" value="Cor*" />
                        @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        <div class="flex items-center gap-2">
                            <input type="color" wire:model.defer="form.color" id="color" class="w-10 h-10 p-0 border rounded-md" />
                            <x-text-input type="text" wire:model.defer="form.color" id="color_code" class="w-full" placeholder="#000000" />
                        </div>
                    </div>
                </div>

                <!-- Botões de Ação -->
                <div class="flex justify-end space-x-3">
                    <x-secondary-button wire:click="toggleInput" class="border border-red-800 text-red-500">
                        <x-cancel-icon width="16px" height="16px" color="currentColor"/>
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button type="submit" class="bg-green-600 hover:bg-green-500">
                        <x-save-icon width="16px" height="16px" color="currentColor"/>
                        Salvar
                    </x-primary-button>
                </div>
            </form>
        @endif
    </div>
</x-modal>
