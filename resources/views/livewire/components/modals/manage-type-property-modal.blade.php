<x-modal :name="'manage-type-property'" maxWidth="2xl">
    <div class="p-6 space-y-6">
        <!-- Header do Modal -->
        <div class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
            <x-config-icon width="24px" height="24px" color="currentColor" />
            <h2 class="text-xl font-semibold">
                Gerenciar Tipos de Propriedades
            </h2>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Configure e gerencie os diferentes tipos de propriedades disponíveis no sistema. Adicione, edite ou remova conforme necessário.
        </p>
        <div class="mt-1 mb-1">
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

        <div>
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-300 mb-2">
                Tipos de Propriedades Cadastrados
            </h3>
            @if ($this->form->typeProperty->isEmpty())
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Nenhum tipo cadastrado ainda.
                </p>
            @else
                <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($this->form->typeProperty as $type)
                        <li class="py-2 flex items-center justify-between">
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                {{ $type->name }}
                            </span>
                            <div class="flex items-center justify-end gap-x-4">
                                <button
                                    wire:click="editTypeProperty({{ $type->id }})"
                                    class="text-blue-600 dark:text-blue-400 text-sm hover:underline"
                                >
                                    <x-edit-icon width="14px" height="14px" color="currentColor"/>
                                </button>
                                <button
                                    wire:click="deleteTypeProperty({{ $type->id }})"
                                    wire:confirm="Você deseja remover o tipo cadastrado?"
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
                class="w-full gap-2 border text-red-500 border-red-500 bg-transparent flex justify-center items-center "
            >
                <x-cancel-icon width="16px" height="16px" color="currentColor"/>
                Limpar Input
            </x-secondary-button>
        @else
            <!-- Botão para Adicionar Novo Tipo ou Limpar Input -->
            <x-primary-button
                wire:click="toggleInput"
                class="w-full flex justify-center items-center"
            >
                <x-add-icon width="16px" height="16px" color="currentColor"/>
                Adicionar novo tipo de propriedade
            </x-primary-button>
        @endif

        <!-- Input de Novo Tipo ou Edição -->
        @if ($showInput)
            <form wire:submit.prevent="{{ $editingId ? 'update' : 'save' }}" class="space-y-4">
                <div>
                    <x-input-label for="typeName" value="Nome do Tipo de Propriedade" />
                    <x-text-input id="typeName" type="text" wire:model.defer="form.name" placeholder="Ex: Comercial" class="mt-1 block w-full" />
                    @error('form.name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <!-- Botões de Ação -->
                <div class="flex justify-end space-x-3">
                    <x-secondary-button
                        wire:click="toggleInput"
                        class="bg-transparent border border-red-800 text-red-500 gap-1">
                        <x-cancel-icon width="16px" height="16px" color="currentColor"/>
                        Cancelar
                    </x-secondary-button>
                    <x-primary-button
                        class="flex items-center justify-center gap-1 bg-green-600 rounded-[6px] text-white hover:bg-green-500 hover:border-green-900"
                        type="submit">
                        <x-save-icon width="16px" height="16px" color="currentColor"/>
                        Salvar
                    </x-primary-button>
                </div>
            </form>
        @endif
    </div>
</x-modal>
