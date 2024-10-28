    <div class="main-title" style="width: 100%; margin: 20px;">
        <h4>Bem-Vindo, {{ $user->name }}!</h4>
    </div>

    @if ($errors->any())
        <script>
            var errors = @json($errors->all());
            var errorHtml = '<ul>';
            errors.forEach(function(error) {
                errorHtml += '<li>' + error + '</li>';
            });
            errorHtml += '</ul>';

            Swal.fire({
                title: 'Erro de Validação',
                html: errorHtml,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Sucesso!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif



    <div class="form-main" style="width: 96%; margin: 20px;">
        <div class="card">
            <div class="card-header">
                <h4>Cadastro de Propriedades</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('createPropertiesWEB') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Nome do Cidade -->
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Nome da Cidade</label>
                            <input type="text" name="city" class="form-control" id="city" placeholder="Nome da Cidade" required>
                        </div>

                        <!-- Nome do Estado -->
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Nome do Estado</label>
                            <input type="text" name="state" class="form-control" id="state" placeholder="Nome do Estado" required>
                        </div>

                        <!-- Nome do Bairro (opcional) -->
                        <div class="col-md-6 mb-3">
                            <label for="neighborhood" class="form-label">Nome do Bairro</label>
                            <input type="text" name="neighborhood" class="form-control" id="neighborhood" placeholder="Nome do Bairro">
                        </div>

                        <!-- Valor da Propriedade -->
                        <div class="col-md-6 mb-3">
                            <label for="value" class="form-label">Valor da Propriedade (R$)</label>
                            <input type="text" name="value" class="form-control" id="value" placeholder="Valor da Propriedade" required>
                        </div>

                        <!-- Número de Quartos -->
                        <div class="col-md-6 mb-3">
                            <label for="bedrooms" class="form-label">Número de Quartos</label>
                            <input type="number" name="bedrooms" class="form-control" id="bedrooms" placeholder="Número de Quartos" required>
                        </div>

                        <!-- Número de Suites -->
                        <div class="col-md-6 mb-3">
                            <label for="bathrooms" class="form-label">Número de Suíte (opcional)</label>
                            <input type="number" name="bathrooms" class="form-control" id="suites" placeholder="Número de Suítes" required>
                        </div>

                        <!-- Número de Banheiros -->
                        <div class="col-md-6 mb-3">
                            <label for="bathrooms" class="form-label">Número de Banheiros</label>
                            <input type="number" name="bathrooms" class="form-control" id="bathrooms" placeholder="Número de Banheiros" required>
                        </div>

                        <!-- Número de Vagas -->
                        <div class="col-md-6 mb-3">
                            <label for="parking_spaces" class="form-label">Número de Vagas de Garagem</label>
                            <input type="number" name="parking_spaces" class="form-control" id="parking_spaces" placeholder="Número de Vagas de Garagem" required>
                        </div>

                        <!-- Número de Salas -->
                        <div class="col-md-6 mb-3">
                            <label for="living_rooms" class="form-label">Número de Salas</label>
                            <input type="number" name="living_rooms" class="form-control" id="living_rooms" placeholder="Número de Salas" required>
                        </div>

                        <!-- Número de Cozinhas -->
                        <div class="col-md-6 mb-3">
                            <label for="kitchens" class="form-label">Número de Cozinhas</label>
                            <input type="number" name="kitchens" class="form-control" id="kitchens" placeholder="Número de Cozinhas" required>
                        </div>

                        <!-- Número de Piscinas -->
                        <div class="col-md-6 mb-3">
                            <label for="pools" class="form-label">Número de Piscinas (opcional)</label>
                            <input type="number" name="pools" class="form-control" id="pools" placeholder="Número de Piscinas">
                        </div>

                        <!-- Área Construída (m²) -->
                        <div class="col-md-6 mb-3">
                            <label for="built_area" class="form-label">Área Construída (m²)</label>
                            <input type="text" name="built_area" class="form-control" id="built_area" placeholder="Área Construída" required>
                        </div>


                        <!-- Área do Terreno (m²) -->
                        <div class="col-md-6 mb-3">
                            <label for="land_area" class="form-label">Área do Terreno (m²)</label>
                            <input type="text" step="0.01" name="land_area" class="form-control" id="land_area" placeholder="Área do Terreno" required>
                        </div>

                        <!-- Upload da Imagem -->
                        <div class="col-md-12 mb-3">
                            <label for="photo_url" class="form-label">Foto da Propriedade</label>
                            <div class="file-upload-wrapper" style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer;">
                                <input type="file" name="photo_url" class="form-control-file" id="photo_url" required style="display:none;">
                                <span id="file-name" class="text-muted">Clique ou arraste uma imagem aqui</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-success">Cadastrar Propriedade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Custom JavaScript para exibir o nome do arquivo selecionado
        document.querySelector('.file-upload-wrapper').addEventListener('click', function () {
            document.getElementById('photo_url').click();
        });

        document.getElementById('photo_url').addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : 'Clique ou arraste uma imagem aqui';
            document.getElementById('file-name').textContent = fileName;
        });

        // Máscara para o valor da propriedade (R$)
        $(document).ready(function () {
            $('#value').mask('000.000.000.000.000,00', {reverse: true}).on('blur', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
                $(this).val(value === '' ? '' : parseFloat(value / 100).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }));
            });

            // Máscara para áreas (m²)
            $('#built_area').mask('000.000,00', {reverse: true}).on('blur', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
                if (value !== '') {
                    var formattedValue = (parseInt(value) / 100).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(this).val(formattedValue + ' m²');
                } else {
                    $(this).val('');
                }
            });

            $('#land_area').mask('000.000,00', {reverse: true}).on('blur', function() {
                var value = $(this).val().replace(/\D/g, ''); // Remove caracteres não numéricos
                if (value !== '') {
                    var formattedValue = (parseInt(value) / 100).toLocaleString('pt-BR', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    $(this).val(formattedValue + ' m²');
                } else {
                    $(this).val('');
                }
            });

            // Remover máscara do valor da propriedade antes do envio
            $('form').on('submit', function () {
                var rawValue = $('#value').val().replace(/\D/g, ''); // Remove caracteres não numéricos
                $('#value').val(rawValue === '' ? '' : (parseFloat(rawValue) / 100).toFixed(2)); // Armazena apenas o valor em formato decimal
            });
        });
    </script>

