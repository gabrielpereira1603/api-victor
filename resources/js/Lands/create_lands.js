import L from "leaflet";
// Se estiver usando build com NPM/webpack/vite, também importe o CSS:
import '@geoman-io/leaflet-geoman-free/dist/leaflet-geoman.css';
import '@geoman-io/leaflet-geoman-free';

document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map-create-lands');
    if (!mapElement) return;

    const firstCoordinates = mapElement.dataset.first_coordinates;
    const blocksCoordinates = mapElement.dataset.blocks_coordinates;
    const landsCoordinates = mapElement.dataset.lands_coordinates;
    const subdivisionCoordinates = mapElement.dataset.subdivision_coordinates;
    const subdivisionDetails = JSON.parse(mapElement.dataset.subdivision_details);

    if (firstCoordinates) {
        initializeMap(firstCoordinates, subdivisionCoordinates, blocksCoordinates, landsCoordinates, subdivisionDetails);
    }
});

function initializeMap(firstCoordinates, subdivisionCoordinates, blocksCoordinates, landsCoordinates, subdivisionDetails) {
    const map = L.map('map-create-lands', {
        center: firstCoordinates.split(',').map(parseFloat),
        zoom: 18,
        minZoom: 15,
        maxZoom: 22,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    // Camada onde os novos polígonos serão armazenados
    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Ativa os controles do Leaflet-Geoman
    map.pm.addControls({
        position: 'topleft',
        drawPolygon: true,
        editMode: true,
        dragMode: true,
        cutPolygon: true,
        removalMode: true
    });

    // Opções globais para snapping
    map.pm.setGlobalOptions({
        snapToSelf: false,
        snapDistance: 20
    });

    // Evento de criação de polígono
    map.on('pm:create', e => {
        const layer = e.layer;
        drawnItems.addLayer(layer);

        const coordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

        console.log('Coordenadas desenhadas:', coordinates);

        Livewire.dispatch('updateCoordinates', { coordinates });

        const coordinatesInput = document.getElementById('coordinates');
        if (coordinatesInput) {
            coordinatesInput.value = JSON.stringify(coordinates);
        }
    });

    // Evento de edição de polígono
    map.on('pm:edit', e => {
        e.layers.eachLayer(layer => {
            const updatedCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

            console.log('Coordenadas atualizadas:', updatedCoordinates);

            const coordinatesInput = document.getElementById('coordinates');
            if (coordinatesInput) {
                coordinatesInput.value = JSON.stringify(updatedCoordinates);
            }

            Livewire.dispatch('updateCoordinates', { coordinates: updatedCoordinates });
        });
    });

    // Exibir Subdivisão
    if (subdivisionCoordinates) {
        const parsedSubdivision = JSON.parse(subdivisionCoordinates);
        L.polygon(parsedSubdivision, { color: 'yellow', weight: 2, fillColor: '#FFFF99', fillOpacity: 0.4 })
            .addTo(map)
            .bindPopup(`
                <strong>Subdivisão: </strong> ${subdivisionDetails.name} <br>
                <strong>Cidade: </strong> ${subdivisionDetails.city},
                <strong>Estado: </strong> ${subdivisionDetails.state} <br>
                <strong>Bairro: </strong> ${subdivisionDetails.neighborhood} <br>
                <strong>Status: </strong> ${subdivisionDetails.status} <br>
                <strong>Área: </strong> ${subdivisionDetails.area} m² <br>
            `)
            .openPopup();
    }

    // Exibir Blocks (Quarteirões)
    if (blocksCoordinates) {
        const parsedBlocks = JSON.parse(blocksCoordinates);
        parsedBlocks.forEach(block => {
            const polygon = L.polygon(JSON.parse(block.coordinates), {
                color: 'green',
                weight: 2,
                fillColor: '#90EE90',
                fillOpacity: 0.5
            }).addTo(map);

            polygon.on('click', () => {
                L.popup()
                    .setLatLng(polygon.getBounds().getCenter())
                    .setContent(`
                        <strong>Quarteirão:</strong> ${block.name} <br>
                        <strong>Status:</strong> ${block.status} <br>
                        <strong>Área:</strong> ${block.area} m²
                    `)
                    .openOn(map);
            });
        });
    }

    // Exibir Lands (Terrenos)
    if (landsCoordinates) {
        const parsedLands = JSON.parse(landsCoordinates);
        parsedLands.forEach(land => {
            const polygon = L.polygon(JSON.parse(land.coordinates), {
                color: land.color || 'red',
                weight: 2,
                fillColor: land.color || 'red',
                fillOpacity: 0.6
            }).addTo(map);

            polygon.on('click', () => {
                L.popup()
                    .setLatLng(polygon.getBounds().getCenter())
                    .setContent(`
                        <p><strong>Código:</strong> ${land.code}</p>
                        <p><strong>Área:</strong> ${land.area}</p>
                        <p><strong>Tamanho de frente:</strong> ${land.front_size}</p>
                        <p><strong>Tamanho de fundo:</strong> ${land.background_size}</p>
                        <p><strong>Status:</strong> ${land.status}</p>
                    `)
                    .openOn(map);
            });
        });
    }
}
