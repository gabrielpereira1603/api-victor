document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map-create-blocks');
    const firstCoordinates = mapElement.dataset.first_coordinates;
    const subdivisionCoordinates = mapElement.dataset.subdivision_coordinates;
    const blocksCoordinates = mapElement.dataset.blocks_coordinates;

    if (!mapElement) {
        return;
    }

    if (firstCoordinates && firstCoordinates.length > 0) {
        // Inicializa o mapa com as coordenadas de primeiro ponto e da subdivisão
        initializeMap([firstCoordinates], [subdivisionCoordinates], [blocksCoordinates]);
    }
});

// Função para inicializar o mapa
function initializeMap(coordinates, subdivisionCoordinates, blocksCoordinates) {
    // Verifique se as coordenadas são válidas
    if (Array.isArray(coordinates) && coordinates.length > 0) {
        coordinates = coordinates[0].split(',').map(coord => parseFloat(coord.trim())); // Converter as coordenadas em números
        console.log('Coordenadas de inicialização:', coordinates);
    } else {
        console.error("Coordenadas inválidas:", coordinates);
        return;
    }

    // Verifique as coordenadas da subdivisão e converta para o formato necessário
    if (Array.isArray(subdivisionCoordinates) && subdivisionCoordinates.length > 0) {
        // Converte a string das coordenadas para um array de arrays de números
        subdivisionCoordinates = JSON.parse(subdivisionCoordinates[0]);
        console.log('Coordenadas da subdivisão convertidas:', subdivisionCoordinates);
    } else {
        console.error("Coordenadas da subdivisão inválidas:", subdivisionCoordinates);
        return;
    }

    // Inicializar o mapa
    const map = L.map('map-create-blocks', {
        center: [coordinates[0], coordinates[1]], // Centro do mapa usando as coordenadas iniciais
        zoom: 18, // Nível de zoom inicial
        minZoom: 15, // Zoom mínimo
        maxZoom: 22, // Zoom máximo
        zoomControl: true, // Ativar controles de zoom
        scrollWheelZoom: true, // Ativar zoom com rolagem do mouse
        dragging: true // Ativar arrasto do mapa
    });

    // Camada de tiles (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    // Adicionar um marcador para a coordenada inicial
    const marker = L.marker([coordinates[0], coordinates[1]]).addTo(map);
    marker.bindPopup('<b>Coordenada Inicial</b>').openPopup();

    // Desenhar o polígono da subdivisão com linha pontilhada e sem preenchimento
    const polygon = L.polygon(subdivisionCoordinates, {
        color: 'blue', // Cor da linha
        weight: 2, // Espessura da linha
        dashArray: '5,5', // Linha pontilhada (sublinhada)
        fillOpacity: 0 // Sem preenchimento
    }).addTo(map);

    // Exibir popup ao clicar no polígono
    polygon.bindPopup('<h3>Subdivisão</h3><p>Área: Desconhecida</p>');

    // Desenhar os blocks com linha reta e lisa
    if (blocksCoordinates) {
        try {
            const parsedBlocksCoordinates = JSON.parse(blocksCoordinates);

            if (Array.isArray(parsedBlocksCoordinates) && parsedBlocksCoordinates.length > 0) {
                parsedBlocksCoordinates.forEach(block => {
                    const blockArray = JSON.parse(block); // Conversão da string para JSON
                    const blockCoordinates = blockArray.map(coord => [coord[0], coord[1]]);
                    console.log('Coordenadas dos blocks:', blockCoordinates);

                    const blockPolygon = L.polygon(blockCoordinates, {
                        color: 'red',
                        weight: 2,
                        fillOpacity: 0
                    }).addTo(map);

                    blockPolygon.bindPopup('<h3>Block</h3><p>Área: Desconhecida</p>');
                });
            }
        } catch (error) {
            console.error("Erro ao processar coordenadas dos blocks:", error);
        }
    }


    // Inicializar o Leaflet Draw
    const drawnItems = new L.FeatureGroup(); // Camada para armazenar os itens desenhados
    map.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
            remove: true // Permite remover os desenhos
        },
        draw: {
            polygon: {
                shapeOptions: {
                    color: 'green',
                    weight: 5
                }
            },
            rectangle: false, // Não permitir retângulos
            circle: false, // Não permitir círculos
            marker: false, // Não permitir marcadores
            polyline: false // Não permitir linhas
        }
    });

    map.addControl(drawControl);

    // Escutar o evento de criação e adicionar o polígono desenhado ao mapa
    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.addLayer(layer);

        // Corrigir a estrutura das coordenadas antes de enviar
        const newCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

        console.log('Enviando coordenadas para Livewire:', newCoordinates);

        Livewire.dispatch('updateCoordinates', { coordinates: newCoordinates });

        // Atualizar o valor do input hidden
        const coordinatesInput = document.getElementById('coordinates');
        if (coordinatesInput) {
            coordinatesInput.value = JSON.stringify(newCoordinates);
        }
    });

    // Escutar o evento de edição para atualizar as coordenadas
    map.on(L.Draw.Event.EDITED, function (event) {
        const layers = event.layers;

        layers.eachLayer(function (layer) {
            // Corrigir a estrutura das coordenadas depois da edição
            const updatedCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

            console.log('Coordenadas atualizadas para Livewire:', updatedCoordinates);

            // Atualizar o valor do input hidden
            const coordinatesInput = document.getElementById('coordinates');
            if (coordinatesInput) {
                coordinatesInput.value = JSON.stringify(updatedCoordinates);
            }

            // Enviar as coordenadas atualizadas para o Livewire
            Livewire.dispatch('updateCoordinates', { coordinates: updatedCoordinates });
        });
    });

    console.log('Mapa inicializado com sucesso!');
}
