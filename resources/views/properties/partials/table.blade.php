<div class="overflow-x-auto p-6">
    <table class="min-w-full bg-white dark:bg-gray-800">
        <thead>
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Valor
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Área Construída
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Área do Terreno
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Bairro
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Estado
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Cidade
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Status
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">
                Ações
            </th>
        </tr>
        </thead>
        <tbody class="bg-white overflow-visible divide-y divide-gray-200 dark:bg-gray-700 dark:divide-gray-600">
        @foreach ($properties as $property)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ 'R$ ' . number_format($property->value, 2, ',', '.') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $property->built_area }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $property->land_area }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $property->neighborhood->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $property->state->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                    {{ $property->city->name ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if ($property->trashed())
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
                            @if ($property->trashed())
                                <!-- Ações para propriedades desativadas -->
                                <x-dropdown-link href="{{ route('properties.restore', $property->id) }}" class="flex items-center"
                                                 onclick="event.preventDefault(); document.getElementById('restore-property-{{ $property->id }}').submit();">
                                    <x-restore-icon color="text-green-500" />
                                    Reativar
                                </x-dropdown-link>

                                <x-dropdown-link href="{{ route('properties.forceDelete', $property->id) }}" class="flex items-center"
                                                 onclick="event.preventDefault(); document.getElementById('force-delete-property-{{ $property->id }}').submit();">
                                    <x-delete-icon color="text-red-500" />
                                    Excluir
                                </x-dropdown-link>

                                <form id="restore-property-{{ $property->id }}" action="{{ route('properties.restore', $property->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                                <form id="force-delete-property-{{ $property->id }}" action="{{ route('properties.forceDelete', $property->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @else
                                <!-- Ações para propriedades ativas -->
                                <x-dropdown-link href="javascript:void(0)" class="flex items-center"
                                                 @click="$dispatch('open-modal', 'viewProperty{{ $property->id }}')">
                                    <x-view-icon color="text-blue-500" />
                                    Visualizar
                                </x-dropdown-link>
                                <x-dropdown-link href="javascript:void(0)" class="flex items-center">
                                    <x-photos-icon color="text-blue-500" />
                                    Editar Fotos
                                </x-dropdown-link>
                                <x-dropdown-link href="" class="flex items-center">
                                    <x-edit-icon color="text-amber-500" />
                                    Editar
                                </x-dropdown-link>
                                <x-dropdown-link href="{{ route('properties.disable', $property->id) }}" class="flex items-center"
                                                 onclick="event.preventDefault(); document.getElementById('disable-property-{{ $property->id }}').submit();">
                                    <x-delete-icon color="text-red-500" />
                                    Desativar
                                </x-dropdown-link>

                                <form id="disable-property-{{ $property->id }}" action="{{ route('properties.disable', $property->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </td>
            </tr>

            <x-modal :name="'viewProperty' . $property->id" maxWidth="2xl">
                <div class="p-6 space-y-6">
                    <div class="flex justify-start mb-4">
                        <img src="{{ $property->photo_url }}" alt="Foto da Propriedade" class="w-36 h-36 object-cover rounded-lg shadow-md">
                    </div>

                    <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Detalhes da Propriedade</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><strong>Valor:</strong> R$ {{ number_format($property->value, 2, ',', '.') }}</p>
                        <p><strong>Quartos:</strong> {{ $property->bedrooms }}</p>
                        <p><strong>Banheiros:</strong> {{ $property->bathrooms }}</p>
                        <p><strong>Suítes:</strong> {{ $property->suites }}</p>
                        <p><strong>Salas de Estar:</strong> {{ $property->living_rooms }}</p>
                        <p><strong>Cozinhas:</strong> {{ $property->kitchens }}</p>
                        <p><strong>Vagas da Garagem:</strong> {{ $property->parking_spaces }}</p>
                        <p><strong>Piscinas:</strong> {{ $property->pools }}</p>
                        <p><strong>Área Construída:</strong> {{ $property->built_area }} m²</p>
                        <p><strong>Área do Terreno:</strong> {{ $property->land_area }} m²</p>
                        <p><strong>Data de Criação:</strong> {{ $property->created_at->format('d/m/Y H:i') }}</p>
                        <p><strong>Última Atualização:</strong> {{ $property->updated_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Endereço</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <p><strong>Bairro:</strong> {{ $property->neighborhood->name }}</p>
                        <p><strong>Cidade:</strong> {{ $property->city->name }}</p>
                        <p><strong>Estado:</strong> {{ $property->state->name }}</p>
                    </div>

                    <div class="flex justify-end mt-6">
                        <x-primary-button @click="$dispatch('close-modal', 'viewProperty{{ $property->id }}')">
                            Fechar
                        </x-primary-button>
                    </div>
                </div>
            </x-modal>
        @endforeach
        </tbody>
    </table>
</div>
