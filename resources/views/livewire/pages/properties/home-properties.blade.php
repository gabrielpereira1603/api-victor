<div>
    <x-slot name="header">
        <h2 class="flex gap-1 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-house-icon widht="20px" height="20px" color="currentColor"/>
            {{ __('Propriedades') }}
        </h2>
    </x-slot>
    <livewire:breadcrumb />
    @script
    <script>
        $wire.on('propertyCreated', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            Swal.fire({
                icon: 'success',
                title: 'Propriedade criada com sucesso!',
                text: 'A propriedade foi salva corretamente.',
                confirmButtonColor: '#28a745',
            });
        });
    </script>
    @endscript

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-visible shadow-sm sm:rounded-lg z-0">
                <!-- Header com Título e Botão -->
                <div class="p-6 flex justify-between items-center text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-700">
                    <span class="text-lg font-semibold">{{ __("Gerenciar Propriedades") }}</span>

                    <a href="{{ route('properties.create') }}" class="ms-3">
                        <x-primary-button>
                            <x-add-icon></x-add-icon>
                            {{ __('Cadastrar Propriedade') }}
                        </x-primary-button>
                    </a>
                </div>

                <!-- Tabela -->
                <livewire:components.tables.properties-table :properties="$properties"/>
            </div>
        </div>
    </div>
</div>
