<x-modal :name="'edit-coordinate-block'">
    <div class="p-6 space-y-4 z-[999]">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-200">Editar Coordenadas do Quarteirão</h2>

        <!-- Mapa Leaflet -->
        <div id="edit-coordinate-block-map"
             class="w-full h-96 rounded-lg shadow-sm border border-gray-300 dark:border-gray-700"
             data-block-coordinates="{{ json_encode($coordinates) }}"
             wire:ignore>
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <button type="button" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-500"
                    onclick="Livewire.dispatch('close-modal', 'edit-coordinate-block')">Cancelar</button>
            <button type="button" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500"
                    onclick="saveUpdatedCoordinates()">Salvar</button>
        </div>
    </div>
</x-modal>

