<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Propriedades') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let errorMessages = `
                @foreach ($errors->all() as $error)
                {{ $error }}<br>
                @endforeach
                `;
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    html: errorMessages,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

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
                @include('properties.partials.table', ['properties' => $properties])
            </div>
        </div>
    </div>
</x-app-layout>
