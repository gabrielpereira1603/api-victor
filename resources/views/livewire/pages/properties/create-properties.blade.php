<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-house-add-icon width="20px" height="20px" color="currentColor"/>
            {{ __('Cadastrar Propriedade') }}
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
                    <h2 class="flex gap-1 items-start sm:items-center font-semibold text-lg text-gray-800 dark:text-gray-200">
                        <x-info-icon width="20px" height="20px" color="currentColor"/>
                        {{ __('Os campos sem "*" são opcionais.') }}
                    </h2>

                    <!-- Upload e Pré-visualização da Imagem -->
                    <div class="space-y-4">
                        <div class="bg-gray-100 border-2 border-dashed border-gray-300 dark:bg-gray-700 dark:border-gray-600 rounded-lg p-6 flex flex-col items-center justify-center text-center transition hover:bg-gray-50 dark:hover:bg-gray-800">
                            <label for="photo" class="cursor-pointer w-full flex flex-col items-center justify-center text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">
                                    {{ __('Arraste ou clique para selecionar uma foto.') }}
                                </p>
                            </label>
                            <input type="file" id="photo" wire:model.blur="form.photo" class="hidden">
                            @error('form.photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        @if ($form->photo)
                            <div class="flex flex-col items-center gap-4">
                                @error('form.photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                <div class="relative">
                                    <img src="{{ $form->photo->temporaryUrl() }}"
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
                                        {{ $form->photo->getClientOriginalName() }}
                                    </p>
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Campos do Formulário -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="value" value="Valor*" />
                            @error('form.value') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="value" wire:model.blur="form.value" id="value" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="built_area" value="Área Construída*" />
                            @error('form.built_area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="built_area" wire:model.blur="form.built_area" id="built_area" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="land_area" value="Área do Terreno*" />
                            @error('form.land_area') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <x-text-input type="text" name="land_area" wire:model.blur="form.land_area" id="land_area" class="w-full" />
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

                    <!-- Campo de Descrição -->
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

                    <!-- Botões -->
                    <div class="flex justify-end gap-4">
                        <x-cancel-button onclick="window.location.href='{{ route('properties') }}'" class="flex gap-1 items-center">
                            <x-cancel-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Voltar') }}
                        </x-cancel-button>

                        <x-primary-button type="submit" wire:target="save" class="flex gap-1 items-center">
                            <x-save-icon width="20px" height="20px" color="currentColor" />
                            {{ __('Salvar Propriedade') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <script>
        $(document).ready(function () {
            // Máscara para o campo de valor
            $('#value').mask('000.000.000.000.000,00', { reverse: true }).on('blur', function() {
                var value = $(this).val().replace(/\D/g, '');
                $(this).val(value === '' ? '' : parseFloat(value / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            });

            // Remover máscara e formatar o valor para envio
            $('form').on('submit', function () {
                var rawValue = $('#value').val().replace(/\D/g, ''); // Remove qualquer coisa que não seja número
                $('#value').val(rawValue === '' ? '' : (parseFloat(rawValue) / 100).toFixed(2)); // Converte para o formato adequado
            });

            // Máscara para o campo de área construída (m²)
            $('#built_area').mask('000.000,00', { reverse: true }).on('blur', function() {
                var value = $(this).val().replace(/\D/g, '');
                if (value !== '') {
                    var formattedValue = (parseInt(value) / 100).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(this).val(formattedValue + ' m²');
                } else {
                    $(this).val('');
                }
            });

            // Máscara para o campo de área do terreno (m²)
            $('#land_area').mask('000.000,00', { reverse: true }).on('blur', function() {
                var value = $(this).val().replace(/\D/g, '');
                if (value !== '') {
                    var formattedValue = (parseInt(value) / 100).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(this).val(formattedValue + ' m²');
                } else {
                    $(this).val('');
                }
            });

            // Remover máscara e formatar o valor para envio
            $('form').on('submit', function () {
                var rawValue = $('#value').val().replace(/\D/g, '');
                $('#value').val(rawValue === '' ? '' : (parseFloat(rawValue) / 100).toFixed(2));
            });
        });
    </script>

</div>
