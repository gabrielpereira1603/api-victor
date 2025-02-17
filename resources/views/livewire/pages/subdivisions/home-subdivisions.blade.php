<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-area-icon widht="20px" height="20px" color="currentColor"/>
            {{ __('Loteamentos') }}
        </h2>
    </x-slot>
    <livewire:breadcrumb />
    @script
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('propertyUpdated', (data) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Atualização',
                        text: data.message,
                        confirmButtonColor: '#28a745',
                    });
                });
            });
        </script>
    @endscript

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg z-0">
                <div class="p-6 flex justify-between items-center text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-lg font-semibold">{{ __("Gerenciar Loteamentos") }}</span>

                    <div class="flex flex-col items-center gap-2 sm:flex-row sm:items-center sm:gap-4">
                        <a href="{{ route('properties.create') }}" class="w-full sm:w-auto">
                            <x-primary-button class="px-4 py-2 text-sm">
                                <x-add-icon></x-add-icon>
                                {{ __('Cadastrar Loteamento') }}
                            </x-primary-button>
                        </a>

                        <form wire:submit="search" class="w-full sm:w-auto">
                            <div class="flex items-center">
                                <span class="bg-gray-800 px-2 py-2.5 border-l border-gray-900 rounded-l-md dark:bg-gray-200 text-gray-50 dark:text-gray-800">
                                    <x-search-icon width="16px" height="16px" color="currentColor" />
                                </span>
                                <input
                                    wire:model.live="search"
                                    type="text"
                                    name="search"
                                    id="search"
                                    class="w-full sm:w-64 h-9.5 text-sm placeholder-gray-500 border-r border-gray-800 border-l-0 focus:ring-green-500 focus:border-green-500 rounded-r-md dark:text-gray-950"
                                    placeholder="Buscar Loteamento..."
                                />
                            </div>
                        </form>

                        <div wire:loading.delay class="text-gray-600 text-sm">
                            Carregando...
                        </div>
                    </div>
                </div>
                <livewire:components.tables.subdivisions-table :subdivisions="$subdivisions" />

            </div>
        </div>

    </div>
</div>
