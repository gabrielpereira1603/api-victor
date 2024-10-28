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
                                <div class="bg-gray-200 border-2 border-dashed border-gray-400 dark:border-gray-600 rounded-lg p-6 w-full flex flex-col items-center justify-center text-center transition hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-900 dark:text-gray-400">Arraste ou clique para selecionar uma foto</p>
                                </div>
                            </template>

                            <template x-if="photoUrl">
                                <div class="relative w-32 h-32"> <!-- Define o tamanho reduzido aqui -->
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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Valor -->
                        <div>
                            <x-input-label for="value" value="Valor" />
                            <input type="text" name="value" id="value" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Área Construída -->
                        <div>
                            <x-input-label for="built_area" value="Área Construída" />
                            <input type="text" name="built_area" id="built_area" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Área do Terreno -->
                        <div>
                            <x-input-label for="land_area" value="Área do Terreno" />
                            <input type="text" name="land_area" id="land_area" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Quartos -->
                        <div>
                            <x-input-label for="bedrooms" value="Quartos" />
                            <input type="number" name="bedrooms" id="bedrooms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Banheiros -->
                        <div>
                            <x-input-label for="bathrooms" value="Banheiros" />
                            <input type="number" name="bathrooms" id="bathrooms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Suítes -->
                        <div>
                            <x-input-label for="suites" value="Suítes" />
                            <input type="number" name="suites" id="suites" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Salas de Estar -->
                        <div>
                            <x-input-label for="living_rooms" value="Salas de Estar" />
                            <input type="number" name="living_rooms" id="living_rooms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Cozinhas -->
                        <div>
                            <x-input-label for="kitchens" value="Cozinhas" />
                            <input type="number" name="kitchens" id="kitchens" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Vagas de Estacionamento -->
                        <div>
                            <x-input-label for="parking_spaces" value="Vagas de Estacionamento" />
                            <input type="number" name="parking_spaces" id="parking_spaces" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Piscinas -->
                        <div>
                            <x-input-label for="pools" value="Piscinas" />
                            <input type="number" name="pools" id="pools" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Bairro -->
                        <div>
                            <x-input-label for="neighborhood" value="Bairro" />
                            <input type="text" name="neighborhood" id="neighborhood" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Cidade -->
                        <div>
                            <x-input-label for="city" value="Cidade" />
                            <input type="text" name="city" id="city" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>

                        <!-- Estado -->
                        <div>
                            <x-input-label for="state" value="Estado" />
                            <input type="text" name="state" id="state" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" />
                        </div>
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="flex justify-end">
                        <x-primary-button>
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
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
                $(this).val(value === '' ? '' : parseFloat(value / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            });

            // Máscara para o campo de área construída (m²)
            $('#built_area').mask('000.000,00', { reverse: true }).on('blur', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
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
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
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
                var rawValue = $('#value').val().replace(/\D/g, ''); // Remove caracteres não numéricos
                $('#value').val(rawValue === '' ? '' : (parseFloat(rawValue) / 100).toFixed(2)); // Formato decimal simples para envio
            });
        });
    </script>
</x-app-layout>
