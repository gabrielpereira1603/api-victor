<div>
    <x-slot name="header">
        <h2 class="flex gap-2 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <x-area-icon width="20px" height="20px" color="currentColor"/>
            Gerenciar Quarteirões - {{ $subdivision->name }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($blocks as $block)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4">
                    <!-- Mapa do Quarteirão -->
                    <div id="block-map-{{ $block['id'] }}" class="w-full h-40 rounded-lg shadow-sm map-card-manage-block"></div>

                    <!-- Informações do Quarteirão -->
                    <div class="mt-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $block['name'] }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Código: <strong>{{ $block['code'] }}</strong></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Área: <strong>{{ $block['area'] }} m²</strong></p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Status:
                            <span class="px-2 py-1 rounded-md text-white text-xs font-semibold {{ $block['status'] == 'ativo' ? 'bg-red-500' : 'bg-green-500' }}">
                                {{ ucfirst($block['status']) }}
                            </span>
                        </p>
                    </div>

                    <!-- Botões -->
                    <div class="mt-4 flex gap-2">

                        <a href="javascript:void(0)"
                           wire:click="$dispatch('editCoordinateBlock', { id: {{ $block['id'] }} }); "
                           class="flex-1 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                            Editar
                        </a>
                        <button onclick="desativarBlock({{ $block['id'] }})"
                                class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600">
                            Desativar
                        </button>
                    </div>
                </div>
            @endforeach
                <livewire:components.modals.subdivisions.manage.edit-coordinate-block-modal/>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($blocks as $block)
        const blockCoordinates{{ $block['id'] }} = {!! json_encode($block['coordinates']) !!};
        if (blockCoordinates{{ $block['id'] }} && blockCoordinates{{ $block['id'] }}.length > 0) {
            const map = L.map('block-map-{{ $block['id'] }}', {
                center: blockCoordinates{{ $block['id'] }}[0],
                zoom: 18,
                scrollWheelZoom: false,
                dragging: false,
                zoomControl: false
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap Contributors'
            }).addTo(map);

            L.polygon(blockCoordinates{{ $block['id'] }}, {
                color: '{{ $block['color'] ?? "blue" }}',
                fillColor: '{{ $block['color'] ?? "#3f3" }}',
                fillOpacity: 0.4
            }).addTo(map);
        }
        @endforeach
    });

    function desativarBlock(blockId) {
        if (confirm("Tem certeza que deseja desativar este quarteirão?")) {
            // Aqui você pode chamar um endpoint ou disparar um evento Livewire para desativar
            alert("Desativando quarteirão " + blockId);
        }
    }
</script>
