<div>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-900 dark:text-gray-100">
            <div class="flex items-center gap-2">
                <x-edit-icon width="24px" height="24px" color="currentColor" />
                <h2 class="text-xl font-semibold">
                    Editar de terreno
                </h2>
            </div>
            <a href="{{ route('subdivision.landsByBlocks', $block->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @script
                    <script>
                        $wire.on('validationFailed', (event) => {
                            console.log(event)
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro na validação',
                                text: event,
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
                                <x-text-input type="text" name="first_coordinate" wire:model.change="first_coordinate" placeholder="Ex: -23.5505, -46.6333" class="w-full" disabled/>
                                <x-text-input type="text" id="coordinates" wire:model="form.coordinates" name="coordinates" class="w-full hidden" disabled/>
                            </div>

                            <div>
                                <x-input-label for="name" value="Nome do Terreno*" />
                                @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="name" wire:model="form.name" placeholder="Ex: Quarteirão A" id="name" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="code" value="Código do Terreno*" />
                                @error('form.code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="text" name="code" wire:model="form.code" placeholder="Ex: A" id="code" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="status" value="Status*" />
                                @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <select name="status" id="status" wire:model="form.status" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                    <option value="Disponível">Disponível</option>
                                    <option value="Reservado">Reservado</option>
                                    <option value="Indisponível">Indisponível</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="blocks" value="Selecione o quarteirão da qual ele faz parte*" />
                                @error('form.blocks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <select name="blocks" id="blocks" wire:model="form.block_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Selecione um quarteirão</option>
                                    @foreach ($form->blocks as $block)
                                        <option
                                            value="{{ $block->id }}"
                                            {{ $form->block_id == $block->id ? 'selected' : '' }}
                                        >
                                            {{ $block->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <x-input-label for="area" value="Área (m²)*" />
                                @error('form.area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="number" step="0.01" name="area" wire:model="form.area" placeholder="Ex: 100,00 m²" id="area" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="background_size" value="Tamanho de fundo (m)*" />
                                @error('form.background_size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="number" step="0.01" name="background_size" wire:model="form.background_size" placeholder="Ex: 100,00 m" id="background_size" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="front_size" value="Tamanho de frente (m)*" />
                                @error('form.front_size') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <x-text-input type="number" step="0.01" name="front_size" wire:model="form.front_size" placeholder="Ex: 100,00 m" id="front_size" class="w-full" />
                            </div>
                            <div>
                                <x-input-label for="color" value="Cor*" />
                                @error('form.color') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div class="flex items-center gap-2">
                                    <input type="color" wire:model="form.color" id="color" class="w-10 h-10 p-0 border rounded-md" />

                                    <x-text-input type="text" wire:model="form.color" id="color_code" class="w-full" placeholder="#000000" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <x-primary-button type="submit" wire:target="save" class="flex gap-2 items-center">
                            <x-save-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Salvar Terreno') }}
                        </x-primary-button>
                    </div>
                </form>

                <div class="container-map-create-lands" >
                    <h2 class="flex gap-2 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        <x-area-icon width="20px" height="20px" color="currentColor"/>
                        {{ __('Cadastrar Terreno') }}
                    </h2>
                    <div id="map-edit-lands"
                         class="w-full mt-5 h-screen relative z-0"
                         data-first_coordinates="{{ $first_coordinate }}"
                         data-blocks_coordinates="{{ $blocks_coordinate }}"
                         data-edit_land_coordinates="{{ json_encode([
                            'name' => $this->land->name,
                            'status' => $this->land->status,
                            'coordinates' => $this->land->coordinates
                        ]) }}"
                         data-lands_coordinates="{{ $lands_coordinate }}"
                         data-subdivision_coordinates="{{ $subdivision->coordinates }}"
                         data-subdivision_details="{{ json_encode($subdivision_details) }}"
                         wire:ignore
                    >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
