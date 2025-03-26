<div class="z-[10]">
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-900 dark:text-gray-100">
            <div class="flex flex-col items-start justify-start gap-2">
                <h2 class="flex gap-2 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <x-area-icon width="20px" height="20px" color="currentColor"/>
                    Terrenos do {{ $block->name }}
                </h2>
                <h2 class="flex gap-2 items-center font-light text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Selecione um terreno para visualizar mais detalhes.
                </h2>
            </div>
            <a href="{{ route('subdivision.blocks.lands.manage', $subdivision_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                Voltar
            </a>
        </div>
    </x-slot>

    <livewire:breadcrumb />

    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($lands as $land)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <!-- Mapa do Terreno -->
                    <div id="land-map-{{ $land['id'] }}" class="w-full h-40 rounded-lg shadow-sm map-card-manage-land z-[10]"> </div>

                    <!-- Informações do Terreno -->
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $land['name'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Código: <strong>{{ $land['code'] }}</strong></p>

                        <div class="flex flex-col gap-1 mb-1 mt-1">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Área: <strong>{{ $land['area'] }} m²</strong></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tamanho de frente: <strong>{{ $land['front_size'] }} m</strong></p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tamanho de fundo: <strong>{{ $land['background_size'] }} m</strong></p>
                        </div>


                        <p class="text-sm text-gray-600 dark:text-gray-400">Status:
                            <span class="px-2 py-1 rounded-md text-white text-xs font-semibold
                                {{ $land['status'] == 'Disponível' ? 'bg-green-500' : ($land['status'] == 'Reservado' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $land['status'] }}
                            </span>
                        </p>
                    </div>

                    <!-- Botões -->
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('subdivision.lands.edit', $land['id']) }}">
                            <x-primary-button
                                class="w-full flex items-center justify-center">
                                <x-edit-icon width="20px" height="20px" color="currentColor"/>
                                Editar
                            </x-primary-button>
                        </a>

                        <x-cancel-button onclick="desativarLand({{ $land['id'] }})"
                                         class="w-full flex items-center justify-center">
                            <x-delete-icon width="20px" height="20px" color="currentColor"/>
                            Desativar
                        </x-cancel-button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($lands as $land)
        const landCoordinates{{ $land['id'] }} = {!! json_encode($land['coordinates']) !!};
        if (landCoordinates{{ $land['id'] }} && landCoordinates{{ $land['id'] }}.length > 0) {
            const map = L.map('land-map-{{ $land['id'] }}', {
                center: landCoordinates{{ $land['id'] }}[0],
                zoom: 18,
                scrollWheelZoom: false,
                dragging: false,
                zoomControl: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap Contributors'
            }).addTo(map);

            L.polygon(landCoordinates{{ $land['id'] }}, {
                color: '{{ $land['color'] ?? "blue" }}',
                fillColor: '{{ $land['color'] ?? "#3f3" }}',
                fillOpacity: 0.4
            }).addTo(map);
        }
        @endforeach
    });

    function desativarLand(landId) {
        if (confirm("Tem certeza que deseja desativar este terreno?")) {
            alert("Desativando terreno " + landId);
        }
    }
</script>
