import L from "leaflet";

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

    // Adiciona a funcionalidade de desenho e edição apenas para polígonos
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
                    color: 'black',
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

        const coordinatesInput = document.getElementById('coordinates');
        if (coordinatesInput) {
            coordinatesInput.value = JSON.stringify(newCoordinates);
        }
    });

    map.on(L.Draw.Event.EDITED, function (event) {
        const layers = event.layers;

        layers.eachLayer(function (layer) {
            const updatedCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

            console.log('Coordenadas atualizadas para Livewire:', updatedCoordinates);

            const coordinatesInput = document.getElementById('coordinates');
            if (coordinatesInput) {
                coordinatesInput.value = JSON.stringify(updatedCoordinates);
            }

            // Enviar as coordenadas atualizadas para o Livewire
            Livewire.dispatch('updateCoordinates', { coordinates: updatedCoordinates });
        });
    });

    // Exibir Subdivisões, Quarteirões e Terrenos
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
                color: landsCoordinates.color || 'red',
                weight: 2,
                fillColor: landsCoordinates.color || 'red',
                fillOpacity: 0.6
            }).addTo(map);

            polygon.on('click', () => {
                L.popup()
                    .setLatLng(polygon.getBounds().getCenter())
                    .setContent(`
                        <strong>Terreno:</strong> ${land.name} <br>
                        <strong>Código:</strong> ${land.code} <br>
                        <strong>Status:</strong> ${land.status} <br>
                        <strong>Área:</strong> ${land.area} m²
                    `)
                    .openOn(map);
            });
        });
    }


}
