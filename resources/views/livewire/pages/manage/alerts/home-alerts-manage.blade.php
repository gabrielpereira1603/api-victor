<div>
    <x-slot name="header">
        <h2 class="flex gap-2 items-center font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-alert-icon width="24px" height="24px" color="currentColor"/>
            {{ __('Configurações de Alertas') }}
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Gerencie seus alertas cadastrados abaixo:') }}</p>
    </x-slot>

    <div class="">
        <!-- Seção de Alertas Ativos -->
        <div class="p-12">
            <div class="relative mb-6">
                <h3 class="flex items-center gap-2 text-2xl font-bold text-gray-800 dark:text-gray-200">
                    <x-siren-icon width="24px" height="24px" color="#22c55e"/>
                    {{ __('Alertas Ativos') }}
                </h3>
                <div class="w-[110px] h-1 bg-green-500 rounded-full mt-1"></div>
                <div class="absolute w-12 h-12 bg-green-100 text-green-500 rounded-full -top-3 -right-6 flex items-center justify-center animate-bounce">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                <!-- Exemplo de Alerta Ativo -->
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-5">
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-1.5 rounded m-1">
                            {{ __('Ativo') }}
                        </span>
                    </div>
                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('/images/JardimAfonso.jpg') }}" class="w-32 h-32 rounded-md object-cover shadow-md hover:scale-105 transition-transform duration-300" alt="Promoção Final de Ano"/>

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('Promoção Final de Ano') }}
                        </h3>
                    </div>

                    <ul class="flex items-center justify-center gap-5 mt-4 text-sm text-gray-600 dark:text-gray-400">
                        <li>
                            <strong>{{ __('Data de Início:') }}</strong> <span>16/03/2023</span>
                        </li>
                        <li>
                            <strong>{{ __('Data de Fim:') }}</strong> <span>16/03/2024</span>
                        </li>
                    </ul>

                    <div class="flex justify-between mt-5 gap-3">
                        <x-primary-button class="flex items-center justify-center w-full">
                            <x-edit-icon widht="18px" height="18px" color="currentColor"/>
                            {{ __('Editar') }}
                        </x-primary-button>
                        <x-danger-button class="flex items-center justify-center w-full">
                            <x-delete-icon widht="18px" height="18px" color="currentColor"/>
                            {{ __('Remover') }}
                        </x-danger-button>
                    </div>
                </div>

                <!-- Card para Adicionar Novo Alerta -->
                <div class="flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-5 cursor-pointer group">
                    <button class="w-full flex flex-col items-center justify-center gap-2 group-hover:animate-pulse">
                        <div class="bg-green-600 text-white w-16 h-16 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <span class="text-gray-800 dark:text-gray-200 font-medium">{{ __('Adicionar Novo Alerta') }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Seção de Alertas Expirados -->
        <div class="p-12">
            <div class="relative mb-6">
                <h3 class="flex items-center gap-2 text-2xl font-bold text-gray-800 dark:text-gray-200">
                    <x-siren-icon width="24px" height="24px" color="#ef4444"/>
                    {{ __('Alertas Expirados') }}
                </h3>
                <div class="w-[110px] h-1 bg-red-500 rounded-full mt-1"></div>
                <div class="absolute w-12 h-12 bg-red-100 text-red-500 rounded-full -top-3 -right-6 flex items-center justify-center animate-spin">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-4">
                <!-- Exemplo de Alerta Expirado -->
                <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow p-5">
                    <div class="absolute top-2 right-2">
                        <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-1.5 rounded">
                            {{ __('Expirado') }}
                        </span>
                    </div>
                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('/images/Expirado.jpg') }}" class="w-32 h-32 rounded-md object-cover shadow-md hover:scale-105 transition-transform duration-300" alt="Promoção Expirada"/>

                        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('Promoção Expirada') }}
                        </h3>
                    </div>

                    <ul class="mt-4 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                        <li>
                            <strong>{{ __('Data de Início:') }}</strong> <span>01/01/2023</span>
                        </li>
                        <li>
                            <strong>{{ __('Data de Fim:') }}</strong> <span>31/12/2023</span>
                        </li>
                    </ul>

                    <div class="flex justify-between mt-5 gap-3">
                        <x-primary-button class="flex items-center justify-center w-full">
                            <x-edit-icon widht="18px" height="18px" color="currentColor"/>
                            {{ __('Editar') }}
                        </x-primary-button>
                        <x-danger-button class="flex items-center justify-center w-full">
                            <x-delete-icon widht="18px" height="18px" color="currentColor"/>
                            {{ __('Remover') }}
                        </x-danger-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
