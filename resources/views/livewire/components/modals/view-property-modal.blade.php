<div>
    <x-modal :name="'viewProperty' . $property->id" maxWidth="2xl">
        <div class="p-6 space-y-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Detalhes da Propriedade</h2>
            <div class="flex justify-start mb-4">
                <img src="{{ $property->photo_url }}" alt="Foto da Propriedade" class="w-36 h-36 object-cover rounded-lg shadow-md">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input-label for="value" value="Valor: R$ {{ $property->value }}"></x-input-label>
                <x-input-label for="bedrooms" value="Quartos: {{ $property->bedrooms }}"></x-input-label>
                <x-input-label for="bathrooms" value="Banheiros: {{ $property->bathrooms }}"></x-input-label>
                <x-input-label for="suites" value="Suítes: {{ $property->suites }}"></x-input-label>
                <x-input-label for="living_rooms" value="Salas de Estar: {{ $property->living_rooms }}"></x-input-label>
                <x-input-label for="kitchens" value="Cozinhas: {{ $property->kitchens }}"></x-input-label>
                <x-input-label for="parking_spaces" value="Vagas da Garagem: {{ $property->parking_spaces }}"></x-input-label>
                <x-input-label for="pools" value="Piscinas: {{ $property->pools }}"></x-input-label>
                <x-input-label for="built_area" value="Área Construída: {{ $property->built_area }}"></x-input-label>
                <x-input-label for="land_area" value="Área do Terreno: {{ $property->land_area }}"></x-input-label>
                <x-input-label for="created_at" value="Data de Criação: {{ $property->created_at->format('d/m/Y H:i') }}"></x-input-label>
                <x-input-label for="updated_at" value="Data de Criação: {{ $property->updated_at->format('d/m/Y H:i') }}"></x-input-label>
            </div>

            <h4 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Endereço</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input-label for="neighborhoodName" value="Bairro: {{ $property->neighborhood->name }}"></x-input-label>
                <x-input-label for="cityName" value="Cidade: {{ $property->city->name }}"></x-input-label>
                <x-input-label for="stateName" value="Estado: {{ $property->state->name }}"></x-input-label>
            </div>

            <div class="flex justify-end mt-6">
                <x-primary-button @click="$dispatch('close-modal', 'viewProperty{{ $property->id }}')">
                    Fechar
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>
