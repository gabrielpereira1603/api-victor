import L from "leaflet";

document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('view-one-subdivision-map');
    if (!mapElement) {
        return;
    }

    let coordinates = JSON.parse(mapElement.dataset.coordinatesSubdivision);
    const subdivisionData = JSON.parse(mapElement.dataset.subdivision);
    const blocksData = JSON.parse(mapElement.dataset.blocks);
    const landsData = JSON.parse(mapElement.dataset.lands);

    if (Array.isArray(coordinates) && coordinates.length > 0) {
        coordinates = coordinates.map(coord => coord.map(Number));
    } else {
        console.error("Coordenadas inválidas:", coordinates);
        return;
    }

    const map = L.map(mapElement, {
        center: [coordinates[0][0], coordinates[0][1]],
        zoom: 18,
        minZoom: 15,
        maxZoom: 22,
        zoomControl: true,
        scrollWheelZoom: true,
        dragging: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    const subdivisionPolygon = L.polygon(coordinates, {
        color: '#004f6d',
        fillColor: '#004f6d',
        fillOpacity: 0.2
    }).addTo(map);

    subdivisionPolygon.bindPopup(`<h3>${subdivisionData.name}</h3>
        <p><strong>Área:</strong> ${subdivisionData.area} m²</p>
        <p><strong>Localização:</strong> ${subdivisionData.city}, ${subdivisionData.state}</p>
    `);

    const blockPolygons = blocksData.map(block => {
        const blockCoordinates = block.coordinates.map(coord => coord.map(Number));
        const blockPolygon = L.polygon(blockCoordinates, {
            color: '#f97316',
            fillColor: '#f97316',
            fillOpacity: 0.2
        }).addTo(map);

        blockPolygon.bindPopup(`<h3>${block.name}</h3>
            <p><strong>Área:</strong> ${block.area ? block.area + ' m²' : 'N/A'}</p>
            <p><strong>Status:</strong> ${block.status}</p>
        `);

        return { id: block.id, polygon: blockPolygon };
    });

    const landPolygons = landsData.map(land => {
        const landCoordinates = land.coordinates.map(coord => coord.map(Number));
        const landPolygon = L.polygon(landCoordinates, {
            color: land.color || '#9333ea',
            fillColor: land.color || '#9333ea',
            fillOpacity: 0.4
        }).addTo(map);

        const center = landPolygon.getBounds().getCenter();
        const landMarker = L.circleMarker(center, {
            radius: 10,
            color: '#000',
            fillColor: '#fff',
            fillOpacity: 1,
            weight: 2
        }).addTo(map);

        landMarker.bindTooltip(land.code, { permanent: true, direction: "center", className: "land-tooltip" });

        landMarker.on('click', () => {
            landMarker.bindPopup(`<h3>${land.name}</h3>
                <p><strong>Código:</strong> ${land.code}</p>
                <p><strong>Área:</strong> ${land.area}</p>
                <p><strong>Tamanho de frente:</strong> ${land.front_size}</p>
                <p><strong>Tamanho de fundo:</strong> ${land.background_size}</p>
                <p><strong>Status:</strong> ${land.status}</p>
            `).openPopup();
        });

        return { id: land.id, polygon: landPolygon, marker: landMarker };
    });

    // Função para alternar visibilidade
    const toggleVisibility = (id, isChecked, polygons, key = "id") => {
        const item = polygons.find(p => p[key] === parseInt(id));
        if (item) {
            isChecked ? item.polygon.addTo(map) : map.removeLayer(item.polygon);
            if (item.marker) {
                isChecked ? item.marker.addTo(map) : map.removeLayer(item.marker);
            }
        }
    };

    // Controles de visibilidade
    document.querySelectorAll('input[id^="block-"]').forEach(checkbox => {
        checkbox.addEventListener('change', event => {
            toggleVisibility(event.target.id.replace('block-', ''), event.target.checked, blockPolygons);
        });
    });

    document.querySelectorAll('input[id^="land-"]').forEach(checkbox => {
        checkbox.addEventListener('change', event => {
            toggleVisibility(event.target.id.replace('land-', ''), event.target.checked, landPolygons);
        });
    });

    document.getElementById('subdivision-toggle')?.addEventListener('change', event => {
        event.target.checked ? map.addLayer(subdivisionPolygon) : map.removeLayer(subdivisionPolygon);
    });
});
