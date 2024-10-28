<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cadastrar Propriedade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Área de Upload de Foto -->
                    <x-input-label for="value" value="Foto de Capa" />
                    <div x-data="{ photoUrl: null }" class="flex flex-col justify-center w-full">
                        <label for="photo_url" class="cursor-pointer">
                            <template x-if="!photoUrl">
                                <div class="bg-gray-200 border-2 border-dashed border-gray-400 dark:bg-gray-300 dark:border-gray-600 rounded-lg p-6 w-full flex flex-col items-center justify-center text-center transition hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-900 dark:text-gray-400">Arraste ou clique para selecionar uma foto</p>
                                </div>
                            </template>

                            <template x-if="photoUrl">
                                <div class="relative w-32 h-32">
                                    <img :src="photoUrl" alt="Pré-visualização da imagem" class="rounded-lg shadow-lg w-full h-full object-cover">
                                    <button type="button" @click="photoUrl = null; document.getElementById('photo_url').value = ''"
                                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </label>

                        <input type="file" name="photo_url" id="photo_url" class="hidden"
                               @change="let file = $event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => photoUrl = e.target.result;
                            reader.readAsDataURL(file);
                        }">
                    </div>

                    <!-- Campos do Formulário -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="value" value="Valor" />
                            <x-text-input type="text" name="value" id="value" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="built_area" value="Área Construída" />
                            <x-text-input type="text" name="built_area" id="built_area" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="land_area" value="Área do Terreno" />
                            <x-text-input type="text" name="land_area" id="land_area" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="bedrooms" value="Quartos" />
                            <x-text-input type="number" name="bedrooms" id="bedrooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="bathrooms" value="Banheiros" />
                            <x-text-input type="number" name="bathrooms" id="bathrooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="suites" value="Suítes" />
                            <x-text-input type="number" name="suites" id="suites" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="living_rooms" value="Salas de Estar" />
                            <x-text-input type="number" name="living_rooms" id="living_rooms" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="kitchens" value="Cozinhas" />
                            <x-text-input type="number" name="kitchens" id="kitchens" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="parking_spaces" value="Vagas de Estacionamento" />
                            <x-text-input type="number" name="parking_spaces" id="parking_spaces" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="pools" value="Piscinas" />
                            <x-text-input type="number" name="pools" id="pools" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="neighborhood" value="Bairro" />
                            <x-text-input type="text" name="neighborhood" id="neighborhood" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="city" value="Cidade" />
                            <x-text-input type="text" name="city" id="city" class="w-full" />
                        </div>
                        <div>
                            <x-input-label for="state" value="Estado" />
                            <x-text-input type="text" name="state" id="state" class="w-full" />
                        </div>
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="flex justify-end gap-4">
                        <x-secondary-button onclick="window.location.href='{{ route('properties') }}'">
                            {{ __('Voltar') }}
                        </x-secondary-button>
                        <x-primary-button type="submit">
                            {{ __('Salvar Propriedade') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            // Máscara para o campo de valor
            $('#value').mask('000.000.000.000.000,00', { reverse: true }).on('blur', function() {
                var value = $(this).val().replace(/\D/g, '');
                $(this).val(value === '' ? '' : parseFloat(value / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
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
</x-app-layout>
