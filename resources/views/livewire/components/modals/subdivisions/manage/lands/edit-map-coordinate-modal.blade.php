<x-modal :name="'edit-map-coordinate-land-modal'" maxWidth="full" x-init="$nextTick(() => map.invalidateSize())">
    <div class="p-6 z-[999]">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Editar Coordenadas do Quarteirão</h2>

        <!-- Mapa Leaflet -->
        <div id="map-edit-coordinate-lands"
             class="w-full h-[40rem] rounded-lg shadow-sm border border-gray-300 dark:border-gray-700"
             data-land="{{ json_encode($land) }}"
             data-block="{{ json_encode($block) }}"
             data-other-lands="{{ json_encode($otherLands) }}"
             wire:ignore>
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500"
                    onclick="Livewire.dispatch('close-modal', 'edit-map-coordinate-land-modal')">Cancelar</button>
            <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500"
                    onclick="saveUpdatedCoordinates()">Salvar</button>
        </div>
    </div>
</x-modal>
