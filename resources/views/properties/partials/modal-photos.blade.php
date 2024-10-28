<x-modal :name="'editPhotosModal' . $property->id" maxWidth="2xl">
    <div class="p-6 space-y-6">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Editar Fotos da Propriedade</h2>

        @if ($photos->isEmpty())
            <div class="border-2 border-dashed border-gray-400 dark:border-gray-600 rounded-lg p-6 w-full flex flex-col items-center justify-center text-center cursor-pointer"
                 @click="$refs.photoUpload.click()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                </svg>
                <p class="mt-2 text-sm text-gray-900 dark:text-gray-400">Arraste ou clique para selecionar fotos</p>
            </div>
            <input type="file" name="photos[]" multiple class="hidden" x-ref="photoUpload" id="photoUpload" form="photoUploadForm" />

        @else
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($photos as $photo)
                    <div class="relative">
                        <img src="{{ $photo->image_url }}" alt="Foto da Propriedade" class="rounded-lg shadow-lg w-full h-full object-cover">
                        <button type="button" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1"
                                onclick="document.getElementById('delete-photo-{{ $photo->id }}').submit();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <form id="delete-photo-{{ $photo->id }}" action="" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Formulário para envio de novas fotos -->
        <form id="photoUploadForm" action="" method="POST" enctype="multipart/form-data" class="mt-4">
            @csrf
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">Upload Fotos</button>
        </form>

        <div class="flex justify-end mt-6">
            <x-primary-button @click="$dispatch('close-modal', 'editPhotosModal{{ $property->id }}')">Fechar</x-primary-button>
        </div>
    </div>
</x-modal>
