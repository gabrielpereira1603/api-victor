<?php
use Livewire\Volt\Component;

new class extends Component{
    public $modal = false;
};
?>
<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-area-icon width="20px" height="20px" color="currentColor"/>
            Loteamento {{ $subdivision->name }}
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Card: Gerenciar Tipos de Propriedades -->
                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="flex items-center gap-0.5 text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <x-config-icon widht="16px" height="16px" color="currentColor"/>
                            {{ __("Gerenciar Loteamento") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Configure e gerencie o loteamento no qual voçê esta acessado no momento.
                        </p>
                        <div class="mt-4">
                            <a href="javascript:void(0)"
                               @click="$dispatch('open-modal', 'manage-subdivisions')"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                Gerenciar os Loteamentos
                            </a>
                        </div>
                    </div>
                </div>

                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="flex items-center gap-1 text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <x-config-icon widht="16px" height="16px" color="currentColor"/>
                            {{ __("Gerenciar Quarteirões") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Configure os quarteirões cadastrados vinculados ao Loteamento acessado no momento.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('home.alerts') }}"
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                Gerenciar Quarteirões
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de outro card (se precisar adicionar mais) -->
                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="flex items-center gap-1 text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <x-config-icon widht="16px" height="16px" color="currentColor"/>
                            {{ __("Gerenciar Terrenos") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Configure os quarteirões cadastrados vinculados ao Loteamento e aos Quarteirões acessado no momento.
                        </p>
                        <div class="mt-4">
                            <a href="#"
                               class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-600">
                                Personalizar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-6 flex">

        <!-- Mapa à esquerda -->
        <div id="map" class="w-2/3 h-screen relative z-0"
             data-coordinates-subdivision="{{ json_encode($coordinates) }}"
             data-subdivision="{{ json_encode([
                 'name' => $subdivision->name,
                 'area' => $subdivision->area,
                 'status' => $subdivision->status,
                 'city' => $subdivision->city->name,
                 'neighborhood' => $subdivision->neighborhood->name,
                 'state' => $subdivision->state->name,
                 'color' => $subdivision->color
             ])}}"
             data-blocks="{{ json_encode($blocks->toArray()) }}"
             data-coordinates-blocks="{{ json_encode($blocks->pluck('coordinates')) }}"
             data-lands="{{ json_encode($lands->toArray()) }}"
             data-coordinates-lands="{{ json_encode($lands->pluck('coordinates')) }}">
        </div>

        <!-- Painel à direita -->
        <div class="w-1/3 bg-gray-100 p-6 h-screen overflow-y-auto">
            <h2 class="flex items-center text-2xl font-bold mb-4 gap-1">
                <x-config-icon width="20px" height="20px" color="currentColor"/>
                Painel de Gerenciamento
            </h2>
            <p class="text-lg mb-4">Aqui você pode gerenciar os dados do loteamento.</p>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" id="name" class="mt-1 block w-full p-2 border border-gray-300 rounded-md disabled bg-gray-300/50" value="{{ $subdivision->name }}" disabled>
                </div>

                <div>
                    <label for="area" class="block text-sm font-medium text-gray-700">Área</label>
                    <input type="text" id="area" class="mt-1 block w-full p-2 border border-gray-300 rounded-md disabled bg-gray-300/50" value="{{ $subdivision->area }}" disabled>
                </div>
            </div>

            <div class="flex w-full gap-4 mt-4 mb-4">
                <x-primary-button class="flex-1 justify-center" id="add-blocks"
                                  href="javascript:void(0)"
                                  @click="$dispatch('open-modal', 'createBlocks')"
                >
                    <x-add-icon width="20px" height="20px" color="currentColor"/>
                    Cadastrar Quarteirão
                </x-primary-button>
            </div>

            <div class="flex w-full gap-4 mt-4 mb-4">
                <x-primary-button class="flex-1 justify-center" id="add-lands"
                                  href="javascript:void(0)"
                                  @click="$dispatch('open-modal', 'createLands')"
                >
                    <x-add-icon width="20px" height="20px" color="currentColor"/>
                    Cadastrar Terrenos
                </x-primary-button>
            </div>

            <p class="flex items-center gap-1 text-p mb-2 text-gray-600">
                <x-info-icon width="14px" height="14px" color="currentColor"/>
                Gerenciar visualização de Loteamento
            </p>

            <div class="mb-4 flex items-center gap-2">
                <label for="subdivision-toggle" class="block text-sm font-medium text-gray-700">Exibir Loteamento {{ $subdivision->name }}</label>
                <input type="checkbox" id="subdivision-toggle" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-200 ease-in-out rounded focus:ring-indigo-500" checked>
            </div>

            <p class="flex items-center gap-1 text-p mb-2 text-gray-600">
                <x-info-icon width="14px" height="14px" color="currentColor"/>
                Gerenciar visualização de Quarteirões
            </p>

            <div class="grid grid-cols-2 gap-4">
                @foreach($blocks as $block)
                    <div class="flex items-center gap-2">
                        <label for="block-{{ $block['id'] }}" class="block text-sm font-medium text-gray-700">{{ $block['name'] }}</label>
                        <input type="checkbox" id="block-{{ $block['id'] }}" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-200 ease-in-out rounded focus:ring-indigo-500" checked>
                    </div>
                @endforeach
            </div>

            <p class="flex items-center gap-1 text-p mt-4 text-gray-600">
                <x-info-icon width="14px" height="14px" color="currentColor"/>
                Gerenciar visualização de Terrenos
            </p>
            <div class="grid grid-cols-2 gap-4">
                @foreach($lands as $land)
                    <div class="flex items-center gap-2">
                        <label for="land-{{ $land['id'] }}" class="block text-sm font-medium text-gray-700">{{ $land['name'] }}</label>
                        <input type="checkbox" id="land-{{ $land['id'] }}" class="form-checkbox h-5 w-5 text-indigo-600 transition duration-200 ease-in-out rounded focus:ring-indigo-500" checked>
                    </div>
                @endforeach
            </div>

        </div>

        <livewire:components.modals.lands.create-lands-modal :subdivision="$subdivision" />
        <livewire:components.modals.blocks.create-blocks-modal :subdivision="$subdivision" />
    </div>

</div>

