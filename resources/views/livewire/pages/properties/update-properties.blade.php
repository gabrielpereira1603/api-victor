<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-edit-icon width="20px" height="20px" color="currentColor"/>
            {{ __('Editar Propriedade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 space-y-6">
                <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-5">
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
                    @if ($errors->any())
                        <div class="bg-red-500 text-white p-4 rounded-md">
                            <p><strong>Por favor, corrija os erros abaixo:</strong></p>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <h2 class="flex gap-1 items-start sm:items-center font-semibold text-lg text-gray-800 dark:text-gray-200">
                        <x-info-icon width="20px" height="20px" color="currentColor"/>
                        {{ __('Os campos sem "*" são opcionais.') }}
                    </h2>

                    <div class="space-y-4">
                        <div class="bg-gray-100 border-2 border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-6 flex flex-col items-center justify-center text-center transition hover:bg-gray-50 dark:hover:bg-gray-800">
                            <label for="photo" class="cursor-pointer w-full flex flex-col items-center justify-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Clique para alterar a foto cadastrada!') }}
                                </p>
                            </label>
                            <input type="file" id="photo" wire:model.blur="form.new_photo" class="hidden">
                            @error('form.new_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex justify-start items-center gap-12">
                        <!-- Imagem Atual -->
                        <div class="flex flex-col items-center">
                            <h2 class="flex items-center font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">
                                <x-photos-icon color="currentColor" />
                                {{ __('Imagem Atual') }}
                            </h2>
                            @if ($property->photo_url)
                                <div class="relative w-36 h-36">
                                    <img src="{{ $property->photo_url }}"
                                         alt="Foto selecionada"
                                         class="w-full h-full object-cover rounded-lg shadow-md">
                                    <button type="button" wire:click="clearPhoto"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <p class="text-gray-500 text-center">Nenhuma imagem cadastrada.</p>
                            @endif
                        </div>

                        <!-- Nova Imagem Selecionada -->
                        <div class="flex flex-col items-center">
                            <h2 class="flex items-center font-semibold text-lg text-gray-800 dark:text-gray-200 mb-2">
                                <x-photos-icon color="currentColor" />
                                {{ __('Nova imagem selecionada') }}
                            </h2>
                            @if ($form->new_photo)
                                <div class="relative w-36 h-36">
                                    <img src="{{ $form->new_photo->temporaryUrl() }}"
                                         alt="Foto selecionada"
                                         class="w-full h-full object-cover rounded-lg shadow-md">
                                    <button type="button"
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @else
                                <p class="text-gray-500 text-center">Nenhuma nova imagem selecionada.</p>
                            @endif
                        </div>
                    </div>


                    <!-- Campos do Formulário -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="value" value="Valor*" />
                            @error('form.value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="value" wire:model.blur="form.value" id="value" class="w-full" oninput="applyCurrencyMask(this)" />
                        </div>
                        <div>
                            <x-input-label for="built_area" value="Área Construída*" />
                            @error('form.built_area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="built_area" wire:model.blur="form.built_area" id="built_area" class="w-full" oninput="applyAreaMask(this)" />
                        </div>
                        <div>
                            <x-input-label for="land_area" value="Área do Terreno*" />
                            @error('form.land_area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="land_area" wire:model.blur="form.land_area" id="land_area" class="w-full" oninput="applyAreaMask(this)" />
                        </div>
                        <div>
                            <x-input-label for="bedrooms" value="Quartos" />
                            <x-text-input type="number" name="bedrooms" wire:model.blur="form.bedrooms" id="bedrooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="bathrooms" value="Banheiros" />
                            <x-text-input type="number" name="bathrooms" wire:model.blur="form.bathrooms" id="bathrooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="suites" value="Suítes" />
                            <x-text-input type="number" name="suites" wire:model.blur="form.suites" id="suites" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="living_rooms" value="Salas de Estar" />
                            <x-text-input type="number" name="living_rooms" wire:model.blur="form.living_rooms" id="living_rooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="kitchens" value="Cozinhas" />
                            <x-text-input type="number" name="kitchens" wire:model.blur="form.kitchens" id="kitchens" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="parking_spaces" value="Vagas de Estacionamento" />
                            <x-text-input type="number" name="parking_spaces" wire:model.blur="form.parking_spaces" id="parking_spaces" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="ramps" value="Rampas" />
                            <x-text-input type="number" name="ramps" wire:model.blur="form.ramps" id="ramps" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="machine_rooms" value="Casa de Máquinas" />
                            <x-text-input type="number" name="machine_rooms" wire:model.blur="form.machine_rooms" id="machine_rooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="writtens" value="Escritórios" />
                            <x-text-input type="number" name="writtens" wire:model.blur="form.writtens" id="writtens" class="w-full" />
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="maps" value="Link do Mapa"/>
                            <x-text-input
                                name="maps"
                                wire:model.blur="form.maps"
                                id="maps"
                                rows="5"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </x-text-input>
                        </div>

                        <div>
                            <x-input-label for="type_property" value="Tipo de Propriedade" />
                            <select
                                id="type_property"
                                wire:model.blur="form.type_property"
                                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Selecione um tipo</option>
                                @foreach ($typeProperties as $type)
                                    <option value="{{ $type->id }}" {{ $form->type_property == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_property') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <x-input-label for="description" value="Descrição Adicional" />
                        <x-text-area
                            name="description"
                            wire:model.blur="form.description"
                            id="description"
                            rows="5"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </x-text-area>
                    </div>


                    <!-- Botão Salvar -->
                    <div class="flex justify-end gap-4">
                        <x-cancel-button onclick="window.location.href='{{ route('properties') }}'" class="flex gap-2 items-center">
                            <x-cancel-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Cancelar Alterações') }}
                        </x-cancel-button>

                        <x-primary-button type="submit" wire:target="save" class="flex gap-2 items-center">
                            <x-save-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Salvar Alterações') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Máscara para moeda (R$)
        function applyCurrencyMask(input) {
            let value = input.value.replace(/\D/g, ''); // Remove tudo que não for dígito
            value = (value / 100).toFixed(2) + ''; // Converte para decimal com 2 casas
            value = value.replace('.', ','); // Troca o ponto por vírgula
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.'); // Adiciona os pontos para milhares
            input.value = 'R$ ' + value; // Adiciona o símbolo de Real
        }

        // Máscara para área (m²) com formato 150,00 m²
        function applyAreaMask(input) {
            let value = input.value.replace(/[^\d]/g, ''); // Remove tudo que não for número

            // Verifica se o campo está vazio
            if (value === '') {
                input.value = '0,00 m²'; // Define um valor padrão quando vazio
                return;
            }

            // Converte o valor para decimal com 2 casas e adiciona o sufixo "m²"
            value = (value / 100).toFixed(2).replace('.', ',');
            input.value = value + ' m²';
        }

        // Adiciona os eventos de entrada e blur
        document.addEventListener('DOMContentLoaded', () => {
            const valueInput = document.getElementById('value');
            const builtAreaInput = document.getElementById('built_area');
            const landAreaInput = document.getElementById('land_area');

            // Aplica a máscara inicialmente
            if (valueInput) applyCurrencyMask(valueInput);
            if (builtAreaInput) applyAreaMask(builtAreaInput);
            if (landAreaInput) applyAreaMask(landAreaInput);

            // Reaplica a máscara ao digitar
            if (builtAreaInput) {
                builtAreaInput.addEventListener('input', () => applyAreaMask(builtAreaInput));
            }
            if (landAreaInput) {
                landAreaInput.addEventListener('input', () => applyAreaMask(landAreaInput));
            }
        });
    </script>

</div>
