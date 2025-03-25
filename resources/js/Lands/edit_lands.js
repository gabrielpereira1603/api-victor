import L from "leaflet";

document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map-edit-lands');
    if (!mapElement) return;

    const firstCoordinates = mapElement.dataset.first_coordinates;
    const blocksCoordinates = mapElement.dataset.blocks_coordinates;
    const landsCoordinates = mapElement.dataset.lands_coordinates;
    const editLand = JSON.parse(mapElement.dataset.edit_land_coordinates || "null");
    const subdivisionCoordinates = mapElement.dataset.subdivision_coordinates;
    const subdivisionDetails = JSON.parse(mapElement.dataset.subdivision_details);

    if (firstCoordinates) {
        initializeMap(firstCoordinates, subdivisionCoordinates, blocksCoordinates, landsCoordinates, editLand, subdivisionDetails);
    }
});

function initializeMap(firstCoordinates, subdivisionCoordinates, blocksCoordinates, landsCoordinates, editLand, subdivisionDetails) {
    const map = L.map('map-edit-lands', {
        center: firstCoordinates.split(',').map(parseFloat),
        zoom: 18,
        minZoom: 15,
        maxZoom: 22,
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Apenas ativar edição para o terreno em edição
    if (editLand) {
        const editPolygon = L.polygon(JSON.parse(editLand.coordinates), {
            color: 'red', // Destacar em vermelho
            weight: 2,
            fillColor: '#FF6347',
            fillOpacity: 0.8
        }).addTo(drawnItems);

        editPolygon.bindPopup(`
            <strong>Editando Terreno:</strong> ${editLand.name} <br>
            <strong>Status:</strong> ${editLand.status}
        `);

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems,
                remove: false // Não permitir remover, apenas editar
            },
            draw: false // Não permitir criação de novos polígonos
        });

        map.addControl(drawControl);

        // Atualizar coordenadas quando editado
        map.on(L.Draw.Event.EDITED, function (event) {
            event.layers.eachLayer(layer => {
                const updatedCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);

                console.log('Enviando coordenadas para Livewire:', updatedCoordinates);

                Livewire.dispatch('updateCoordinates', { coordinates: updatedCoordinates });

                const coordinatesInput = document.getElementById('coordinates');
                if (coordinatesInput) {
                    coordinatesInput.value = JSON.stringify(updatedCoordinates);
                }
            });
        });
    }

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

    if (landsCoordinates) {
        const parsedLands = JSON.parse(landsCoordinates);
        parsedLands.forEach(land => {
            const polygon = L.polygon(JSON.parse(land.coordinates), {
                color: 'blue',
                weight: 2,
                fillColor: '#ADD8E6',
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
