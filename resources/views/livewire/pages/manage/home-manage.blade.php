<?php
use Livewire\Volt\Component;

new class extends Component{
    public $modal = false;
};
?>
<div>
    <x-slot name="header">
        <h2 class="flex gap-2 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-config-icon width="20px" height="20px" color="currentColor"/>
            {{ __('Configurações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Card: Gerenciar Tipos de Propriedades -->
                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="flex items-center gap-0.5 text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <x-house-icon widht="16px" height="16px" color="currentColor"/>
                            {{ __("Gerenciar Tipos de Propriedades") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Configure e gerencie os diferentes tipos de propriedades disponíveis no sistema.
                        </p>
                        <div class="mt-4">
                            <a href="javascript:void(0)"
                               @click="$dispatch('open-modal', 'manage-type-property')"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                                Gerenciar tipos de propiedades
                            </a>
                        </div>
                    </div>
                </div>

                <livewire:components.modals.manage-type-property-modal/>

                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="flex items-center gap-1 text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <x-alert-icon widht="16px" height="16px" color="currentColor"/>
                            {{ __("Gerenciar Alertas na Página") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Configure alertas personalizados com períodos de início e fim. Você pode cadastrar novos alertas, editar existentes ou cancelar os que não são mais necessários.
                        </p>
                        <div class="mt-4">
                            <a href="#"
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-600">
                                Configurações de Alertas
                            </a>
                        </div>
                    </div>
                </div>


                <!-- Exemplo de outro card (se precisar adicionar mais) -->
                <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ __("Outras Configurações") }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Personalize outras áreas do sistema conforme suas necessidades.
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
</div>
