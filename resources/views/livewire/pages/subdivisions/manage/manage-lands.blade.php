<div>
    <x-slot name="header">
        <div class="flex justify-between items-center text-gray-900 dark:text-gray-100">
            <div class="flex flex-col items-center gap-2">
                <h2 class="flex gap-2 items-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    <x-area-icon width="20px" height="20px" color="currentColor"/>
                    Quarteirões - Loteamento {{ $subdivision->name }}
                </h2>
                <h2 class="flex gap-2 items-center font-light text-sm text-gray-800 dark:text-gray-200 leading-tight">
                    Selecione um quarteirão para visualizar os terrenos que pertencem a ele.
                </h2>
            </div>
            <a href="{{ route('subdivision.view_one', $subdivision->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-600">
                Voltar
            </a>
        </div>

    </x-slot>

    <div>
        @if(session('success') || session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        title: "{{ session('success') ? 'Sucesso!' : 'Erro!' }}",
                        text: "{{ session('success') ?? session('error') }}",
                        icon: "{{ session('success') ? 'success' : 'error' }}",
                        confirmButtonText: "OK"
                    });
                });
            </script>
        @endif
    </div>

    <div id="subdivision-map" class="w-full h-96 rounded-lg shadow-md"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Criar um mapa centrado no primeiro quarteirão (caso tenha coordenadas)
            @if(count($blocks) > 0)
            const firstBlock = {!! json_encode($blocks[0]['coordinates']) !!};
            const map = L.map('subdivision-map', {
                center: firstBlock[0] ?? [-23.5505, -46.6333], // Coordenada default (São Paulo)
                zoom: 16
            });

            // Adicionar tile do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap Contributors'
            }).addTo(map);

            // Adicionar cada bloco ao mapa
            @foreach($blocks as $block)
            const blockCoords{{ $block['id'] }} = {!! json_encode($block['coordinates']) !!};
            if (blockCoords{{ $block['id'] }} && blockCoords{{ $block['id'] }}.length > 0) {
                L.polygon(blockCoords{{ $block['id'] }}, {
                    color: '{{ $block['color'] ?? "blue" }}',
                    fillColor: '{{ $block['color'] ?? "#3f3" }}',
                    fillOpacity: 0.4
                }).addTo(map)
                    .bindPopup("<b>{{ $block['name'] }}</b><br>Código: {{ $block['code'] }}<br>Área: {{ $block['area'] }} m²");
            }

            // Adicionar terrenos dentro de cada bloco
            @foreach($block['lands'] as $land)
            const landCoords{{ $land['id'] }} = {!! json_encode($land['coordinates']) !!};
            if (landCoords{{ $land['id'] }} && landCoords{{ $land['id'] }}.length > 0) {
                L.polygon(landCoords{{ $land['id'] }}, {
                    color: '{{ $land['status'] == "Disponível" ? "green" : ($land['status'] == "Reservado" ? "yellow" : "red") }}',
                    fillColor: '{{ $land['status'] == "Disponível" ? "#4CAF50" : ($land['status'] == "Reservado" ? "#FFC107" : "#F44336") }}',
                    fillOpacity: 0.6
                }).addTo(map)
                    .bindPopup("<b>Terreno</b><br>Status: {{ $land['status'] }}");
            }
            @endforeach
            @endforeach
            @endif
        });
    </script>


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
                            <span class="px-2 py-1 rounded-md text-white text-xs font-semibold
                                {{ $block['status'] == 'Disponível' ? 'bg-green-500' : ($block['status'] == 'Reservado' ? 'bg-yellow-500' : 'bg-red-500') }}">
                                {{ $block['status'] }}
                            </span>
                        </p>

                        <!-- Exibindo informações sobre os terrenos -->
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            <p>Terrenos Ativos: <strong>{{ $block['activeLands'] }}</strong></p>
                            <p>Terrenos Reservados: <strong>{{ $block['disabledLands'] }}</strong></p>
                            <p>Terrenos Desativados: <strong>{{ $block['reservedLands'] }}</strong></p>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="mt-4 flex gap-2">
                        <a href="{{ route('subdivision.landsByBlocks', $block['id']) }}" class="w-full">
                            <x-primary-button
                                class="w-full flex items-center justify-center"
                                color="gray-800" hoverColor="gray-800/90" focusColor="gray-900" activeColor="gray-800" textColor="white"
                            >
                                <x-view-icon widht="20px" height="20px" color="currentColor"/>
                                Visualizar Terrenos
                            </x-primary-button>
                        </a>
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
