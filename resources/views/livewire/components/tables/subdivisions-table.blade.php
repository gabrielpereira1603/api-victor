<?php
use Livewire\Volt\Component;

new class extends Component{
    public $modal = false;
    public $subdivisions;
};
?>
<div>
    <div class="overflow-auto p-6">
        <div class="mt-2 mb-2">
            @if (session()->has('success'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transition-opacity ease-in duration-1000"
                     x-transition:leave="transition-opacity ease-out duration-1000"
                     class="bg-green-500 text-white p-2 rounded mb-4 opacity-100">
                    {{ session('success') }}
                </div>
            @elseif(session()->has('error'))
                <div x-data="{ show: true }"
                     x-show="show"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-transition:enter="transition-opacity ease-in duration-1000"
                     x-transition:leave="transition-opacity ease-out duration-1000"
                     class="bg-red-500 text-white p-2 rounded mb-4 opacity-100">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <table class="min-w-full bg-white dark:bg-gray-800">
            <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    ID
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Nome
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Cidade
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Estado
                </th>

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Status de Venda
                </th>

                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Status de Atividade
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                    Ações
                </th>
            </tr>
            </thead>
            <tbody class="bg-white overflow-visible divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
                @foreach ($subdivisions as $subdivision)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                            #{{ '' . $subdivision->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $subdivision->neighborhood->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $subdivision->state->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $subdivision->city->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                            {{ $subdivision->status ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if ($subdivision->trashed())
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-red-700 border border-red-300 bg-red-50 rounded-full">
                                            Desativado
                                        </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold text-green-700 border border-green-300 bg-green-50 rounded-full">
                                    Ativado
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium overflow-ellipsis">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 focus:outline-none">
                                        Ações
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @if ($subdivision->trashed())
                                        <!-- Ações para propriedades desativadas -->
                                    @else
                                        <!-- Ações para propriedades ativas -->
                                        <x-dropdown-link href="{{ route('subdivision.view_one', ['subdivision_id' => $subdivision->id]) }}" class="flex items-center">
                                            <x-view-icon color="text-blue-500" />
                                            Visualizar Loteamento
                                        </x-dropdown-link>
                                    @endif
                                </x-slot>
                            </x-dropdown>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
