<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-add-icon width="20px" height="20px" color="currentColor"/>
            {{ __('Cadastrar Loteamento') }}
        </h2>
    </x-slot>
    <livewire:breadcrumb />

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @script
                    <script>
                        $wire.on('validationFailed', () => {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro na validação',
                                text: 'Por favor, revise os campos destacados no formulário!',
                                confirmButtonColor: '#dc3545',
                            });
                        });
                    </script>
                    @endscript
                    <h2 class="flex gap-2 items-start sm:items-center font-semibold text-lg text-gray-800 dark:text-gray-200">
                        <x-info-icon width="20px" height="20px" color="currentColor"/>
                        {{ __('Os campos sem "*" são opcionais.') }}
                    </h2>

                    <div class="space-y-4">

                        <div>
                            <x-input-label value="Coordenadas*" />
                            <button type="button" wire:click="addCoordinate"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-600">
                                Adicionar Coordenada
                            </button>

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
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="name" value="Nome do Loteamento*" />
                                @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="name" wire:model.blur="form.name" id="name" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="status" value="Status*" />
                                @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <select name="status" id="status" wire:model.blur="form.status" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="area" value="Área (m²)" />
                                @error('form.area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="number" step="0.01" name="area" wire:model.blur="form.area" id="area" class="w-full" />
                            </div>

                            <div>
                                <x-input-label for="color" value="Cor*" />
                                @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model.blur="form.color" id="color" class="w-10 h-10 p-0 border rounded-md" />

                                    <x-text-input type="text" wire:model.blur="form.color" id="color_code" class="w-full" placeholder="#000000" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="neighborhood" value="Bairro*" />
                                @error('form.neighborhood') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="neighborhood" wire:model.blur="form.neighborhood" id="neighborhood" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="city" value="Cidade*" />
                                @error('form.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="city" wire:model.blur="form.city" id="city" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="state" value="Estado*" />
                                @error('form.state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="state" wire:model.blur="form.state" id="state" class="w-full" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <x-cancel-button onclick="window.location.href='{{ route('properties') }}'" class="flex gap-2 items-center">
                            <x-cancel-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Voltar') }}
                        </x-cancel-button>

                        <x-primary-button type="submit" wire:target="save" class="flex gap-2 items-center">
                            <x-save-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Salvar Loteamento') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
