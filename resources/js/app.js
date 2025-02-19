import './bootstrap';
import flatpickr from "flatpickr";
import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import './Calendar/Alert.js';
import './Subdivisions/create_subdivisions.js';
import 'leaflet-draw';
import 'leaflet-draw/dist/leaflet.draw.css';

// Adiciona Alpine ao escopo global
window.Alpine = Alpine;
Alpine.start();

// Adiciona Flatpickr ao escopo global
window.flatpickr = flatpickr;
window.L = L;

document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map');
    if (!mapElement) {
        console.error('Elemento do mapa não encontrado.');
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
        minZoom: 15, // Permite um zoom mais amplo
        maxZoom: 22, // Permite um zoom mais detalhado
        zoomControl: true, // Ativa os controles de zoom
        scrollWheelZoom: true,
        dragging: true
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap Contributors'
    }).addTo(map);

    const polygon = L.polygon(coordinates, {
        color: subdivisionData.color || 'green',
        fillColor: subdivisionData.color || '#3f3',
        fillOpacity: 0.2
    }).addTo(map);

    polygon.bindPopup(`<h3>${subdivisionData.name}</h3><p><strong>Área:</strong> ${subdivisionData.area} m²</p>`);

    // Adicionando controles de desenho
    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems,
            remove: true
        },
        draw: {
            polygon: true,
            rectangle: true,
            circle: false,
            marker: false,
            polyline: false
        }
    });

    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.addLayer(layer);

        const newCoordinates = layer.getLatLngs()[0].map(latlng => [latlng.lat, latlng.lng]);
        console.log("Novo polígono desenhado:", newCoordinates);

        fetch('/salvar-poligono', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ coordinates: newCoordinates })
        })
            .then(response => response.json())
            .then(data => {
                console.log("Salvo com sucesso:", data);
            })
            .catch(error => {
                console.error("Erro ao salvar:", error);
            });
    });

    const blockPolygons = blocksData.map(block => {
        const blockCoordinates = block.coordinates.map(coord => coord.split(',').map(Number));
        const blockPolygon = L.polygon(blockCoordinates, {
            color: block.color || 'blue',
            fillColor: block.color || '#3f3',
            fillOpacity: 0.2
        }).addTo(map);

        blockPolygon.bindPopup(`<h3>${block.name}</h3><p><strong>Área:</strong> ${block.area} m²</p>`);
        return { blockId: block.id, polygon: blockPolygon };
    });

    const landPolygons = landsData.map(land => {
        const landCoordinates = land.coordinates.map(coord => coord.split(',').map(Number));
        const landPolygon = L.polygon(landCoordinates, {
            color: land.color || 'purple',
            fillColor: land.color || '#f0f',
            fillOpacity: 0.2
        }).addTo(map);

        landPolygon.bindPopup(`<h3>${land.name}</h3><p><strong>Área:</strong> ${land.area} m²</p>`);
        return { landId: land.id, polygon: landPolygon };
    });

    const toggleVisibility = (id, isChecked, polygons) => {
        const item = polygons.find(p => p.blockId === parseInt(id) || p.landId === parseInt(id));
        if (item) {
            isChecked ? item.polygon.addTo(map) : map.removeLayer(item.polygon);
        }
    };

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
        event.target.checked ? map.addLayer(polygon) : map.removeLayer(polygon);
    });
});
