document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map-create-subdivisions');
    console.log('Elemento do mapa encontrado:', mapElement);

    if (!mapElement) {
        console.error('Elemento do mapa não encontrado.');
        return;
    }

    // Escutando o Livewire para quando as coordenadas forem atualizadas
    Livewire.on('firstCoordinateUpdated', (coordinates) => {
        if (coordinates && coordinates.length > 0) {
            // Torna o mapa e o contêiner visíveis, após um pequeno delay para garantir a atualização do DOM
            setTimeout(() => {
                mapElement.style.display = 'block';

                // Acessa o contêiner e o torna visível
                const container_map = document.querySelector('.container-map-create-subdivisions');
                if (container_map) {
                    container_map.style.display = 'block';
                }

                console.log('Coordenadas recebidas:', coordinates);

                // Inicializa o mapa com as coordenadas
                initializeMap(coordinates);
            }, 100); // Delay de 100ms
        } else {
            console.error('Coordenadas inválidas recebidas:', coordinates);
        }
    });
});

// Função para inicializar o mapa
function initializeMap(coordinates) {
    // Verifique se as coordenadas são válidas
    if (Array.isArray(coordinates) && coordinates.length > 0) {
        coordinates = coordinates[0].split(',').map(coord => parseFloat(coord.trim())); // Converter as coordenadas em números
        console.log('Coordenadas convertidas:', coordinates);
    } else {
        console.error("Coordenadas inválidas:", coordinates);
        return;
    }

    // Inicializar o mapa
    const map = L.map('map-create-subdivisions', {
        center: [coordinates[0], coordinates[1]], // Centro do mapa usando as coordenadas
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

    // Opções de visualização do mapa (como a cor)
    const polygon = L.polygon([coordinates], {
        color: 'green', // Cor da borda
        fillColor: '#3f3', // Cor de preenchimento
        fillOpacity: 0.2 // Opacidade do preenchimento
    }).addTo(map);

    // Exibir popup ao clicar no polígono
    polygon.bindPopup('<h3>Loteamento</h3><p>Área: Desconhecida</p>');

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
            rectangle: false, // Pode desmarcar se não quiser permitir retângulos
            circle: false, // Pode desmarcar se não quiser permitir círculos
            marker: false, // Pode desmarcar se não quiser permitir marcadores
            polyline: false // Pode desmarcar se não quiser permitir linhas
        }
    });

    map.addControl(drawControl);

    // Escutar o evento de desenho e adicionar o polígono desenhado ao mapa
    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.addLayer(layer);

        // Corrigindo a estrutura das coordenadas antes de enviar
        const newCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

        console.log('Enviando coordenadas para Livewire:', newCoordinates);

        Livewire.dispatch('updateCoordinates', { coordinates: newCoordinates });

        // Atualizar o valor do input hidden
        const coordinatesInput = document.getElementById('coordinates');
        if (coordinatesInput) {
            coordinatesInput.value = JSON.stringify(newCoordinates);
        }
    });


    console.log('Mapa inicializado com sucesso!');
}
