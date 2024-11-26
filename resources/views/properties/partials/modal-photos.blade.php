<x-modal :name="'editPhotosModal' . $property->id" maxWidth="2xl">
    <div class="p-6 space-y-6" x-data="photoManager()">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Editar Fotos da Propriedade</h2>

        <div class="flex justify-between items-center">
            <x-input-label for="EditPhotos" value="Cadastrar Novas Fotos"></x-input-label>
            <form id="photoUploadForm" action="{{ route('properties.photos.store', ['property' => $property->id]) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                @csrf
                <div class="flex items-center gap-4">
                    <input type="file" name="photos[]" multiple accept="image/*" class="hidden" x-ref="photoUpload" id="photoUpload"
                           @change="handleFiles">
                    <button type="submit" class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                        <x-save-icon color="white" />
                        <span>Salvar Fotos</span>
                    </button>
                </div>
            </form>
        </div>

        <template x-if="selectedPhotos.length === 0">
            <div class="border-2 border-dashed border-gray-400 dark:border-gray-600 rounded-lg p-6 w-full flex flex-col items-center justify-center text-center cursor-pointer"
                 @click="openFileSelector">
                <!-- Ícone e mensagem -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4v8z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10l4 4m0 0l4-4m-4 4V3" />
                </svg>
                <p class="mt-2 text-sm text-gray-900 dark:text-gray-400">Clique aqui para selecionar fotos</p>
            </div>
        </template>


        <div x-show="selectedPhotos.length > 0" class="grid grid-cols-3 md:grid-cols-3 gap-4 mt-4">
            <template x-for="(photo, index) in selectedPhotos" :key="index">
                <div class="relative">
                    <img :src="photo" alt="Foto selecionada" class="rounded-lg shadow-lg w-full h-full object-cover">
                    <button type="button" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1"
                            @click="removePhoto(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </template>
        </div>


        <button type="button" x-show="selectedPhotos.length > 0" @click="openFileSelector" class="flex items-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded mt-4">
            <x-add-icon />
            <span>Selecionar Mais Fotos</span>
        </button>

        <!-- Galeria de Fotos Existentes -->
        <x-input-label for="currentPhotos" value="Fotos Cadastradas"></x-input-label>
        <div class="grid grid-cols-3 md:grid-cols-3 gap-4">
            @foreach ($photos as $photo)
                <div class="relative">
                    <img src="{{ $photo->image_url }}" alt="Foto da Propriedade" class="rounded-lg shadow-lg w-full h-full object-cover">
                    <button type="button" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1"
                            @click.prevent="confirmDelete({{ $photo->id }})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <form id="delete-photo-{{ $photo->id }}" action="{{ route('properties.photos.destroy', ['photo' => $photo->id]) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>

        <div class="flex justify-end mt-6 gap-2">
            <form id="" action="" method="POST" class="mt-4">
                @csrf
                <div class="flex items-center gap-4">
                    <button type="submit" class="flex items-center bg-red-600 hover:bg-red-900 text-white font-semibold py-2 px-4 rounded">
                        <x-delete-icon color="white"/>
                        <span>Apagar Todas as Fotos</span>
                    </button>
                </div>
            </form>
            <x-primary-button @click="$dispatch('close-modal', 'editPhotosModal{{ $property->id }}')">Fechar</x-primary-button>
        </div>
    </div>

    <script>
        function photoManager() {
            return {
                selectedPhotos: [],
                isSelectingFiles: false,

                // Abrir seletor de arquivos
                openFileSelector() {
                    if (!this.isSelectingFiles) {
                        this.isSelectingFiles = true;
                        this.$refs.photoUpload.click();
                    }
                },

                // Manipular arquivos selecionados
                handleFiles(event) {
                    const files = event.target.files;
                    for (let i = 0; i < files.length; i++) {
                        this.selectedPhotos.push(URL.createObjectURL(files[i]));
                    }
                    setTimeout(() => {
                        this.isSelectingFiles = false;
                    }, 500);
                },

                // Remover foto selecionada
                removePhoto(index) {
                    this.selectedPhotos.splice(index, 1);
                },

                // Fechar modal e limpar seleção
                closeModal() {
                    this.selectedPhotos = [];
                    this.$dispatch('close-modal', 'editPhotosModal{{ $property->id }}');
                },

                // Confirmar exclusão de foto
                confirmDelete(photoId) {
                    Swal.fire({
                        title: 'Você tem certeza?',
                        text: "Esta ação não poderá ser desfeita!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim, deletar!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-photo-${photoId}`).submit();
                        }
                    });
                },
            };
        }

    </script>
</x-modal>
