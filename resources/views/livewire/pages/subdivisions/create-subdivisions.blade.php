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

                    <div class="flex gap-2 flex-col">
                        <h2 class="flex gap-2 items-start sm:items-center font-semibold text-lg text-gray-800 dark:text-gray-200">
                            <x-info-icon width="20px" height="20px" color="currentColor"/>
                            {{ __('Os campos sem "*" são opcionais.') }}

                        </h2>
                        <small class="flex gap-1 items-start sm:items-center font-semibold text-p text-gray-800 dark:text-gray-200">
                            {{ __('Pegue a coordenada inicial do loteamento para inicilizar o mapa para marcação.') }}
                            <a class="underline" href="#">Não sabe como pegar a coordenada ? Clique aqui!</a>
                        </small>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="first_coordinate" value="Cordenada Inicial*" />
                                <x-text-input type="text" name="first_coordinate" wire:model.change="first_coordinate" placeholder="Ex: -23.5505, -46.6333" class="w-full" />
                            </div>

                            <input type="" id="coordinates" wire:model="form.coordinates" name="coordinates">
                            <div>
                                <x-input-label for="name" value="Nome do Loteamento*" />
                                @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="name" wire:model="form.name" placeholder="Ex: Loteamento Exemple II" id="name" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="status" value="Status*" />
                                @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <select name="status" id="status" wire:model="form.status" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="active">Ativo</option>
                                    <option value="inactive">Inativo</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="area" value="Área (m²)*" />
                                @error('form.area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="number" step="0.01" name="area" wire:model="form.area" placeholder="Ex: 100,00 m²" id="area" class="w-full" />
                            </div>

                            <div>
                                <x-input-label for="color" value="Cor*" />
                                @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model="form.color" id="color" class="w-10 h-10 p-0 border rounded-md" />

                                    <x-text-input type="text" wire:model="form.color" id="color_code" class="w-full" placeholder="#000000" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="neighborhood" value="Bairro*" />
                                @error('form.neighborhood') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="neighborhood" wire:model="form.neighborhood" id="neighborhood" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="city" value="Cidade*" />
                                @error('form.city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="city" wire:model="form.city" id="city" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="state" value="Estado*" />
                                @error('form.state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="state" wire:model="form.state" id="state" class="w-full" />
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

                <div class="container-map-create-subdivisions" style="display: none">
                    <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <x-area-icon width="20px" height="20px" color="currentColor"/>
                        {{ __('Cadastrar Loteamento') }}
                    </h2>
                    <div id="map-create-subdivisions"
                         class="w-full mt-5 h-screen relative z-0"
                         data-first_coordinates="{{ $first_coordinate }}"
                         wire:ignore
                         style="display: none;">
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>
