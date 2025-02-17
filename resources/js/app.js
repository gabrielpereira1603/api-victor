import './bootstrap';
import flatpickr from "flatpickr";
import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import './Calendar/Alert.js';

// Adiciona Alpine ao escopo global
window.Alpine = Alpine;
Alpine.start();

// Adiciona Flatpickr ao escopo global
window.flatpickr = flatpickr;
window.L = L;

document.addEventListener('DOMContentLoaded', () => {
    const mapElement = document.getElementById('map');
    if (mapElement) {
        // Dados da subdivisão e blocks
        let coordinates = JSON.parse(mapElement.dataset.coordinatesSubdivision);
        const subdivisionData = JSON.parse(mapElement.dataset.subdivision);
        const blocksData = JSON.parse(mapElement.dataset.blocks);

        // Dados dos lands
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
            minZoom: 18,
            maxZoom: 18,
            zoomControl: false,
            scrollWheelZoom: true,
            dragging: true
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap Contributors'
        }).addTo(map);

        // Cria o polígono da subdivisão
        const polygon = L.polygon(coordinates, {
            color: subdivisionData.color || 'green',
            fillColor: subdivisionData.color || '#3f3',
            fillOpacity: 0.2
        }).addTo(map);

        const popupContent = `
            <div class="popup-content" style="font-family: Arial, sans-serif; color: #333;">
                <h3>${subdivisionData.name}</h3>
                <p><strong>Área:</strong> ${subdivisionData.area} m²</p>
                <p><strong>Status:</strong> ${subdivisionData.status}</p>
                <p><strong>Cidade:</strong> ${subdivisionData.city}</p>
                <p><strong>Bairro:</strong> ${subdivisionData.neighborhood}</p>
                <p><strong>Estado:</strong> ${subdivisionData.state}</p>
            </div>
        `;
        polygon.bindPopup(popupContent);

        // Cria os polígonos para os blocks
        const blockPolygons = [];
        blocksData.forEach(block => {
            const blockCoordinates = block.coordinates.map(coord => coord.split(',').map(Number));
            const blockPolygon = L.polygon(blockCoordinates, {
                color: block.color || 'blue',
                fillColor: block.color || '#3f3',
                fillOpacity: 0.2
            }).addTo(map);

            const blockPopupContent = `
                <div class="popup-content" style="font-family: Arial, sans-serif; color: #333;">
                    <h3>${block.name}</h3>
                    <p><strong>Área:</strong> ${block.area} m²</p>
                    <p><strong>Status:</strong> ${block.status}</p>
                    <p><strong>Código:</strong> ${block.code}</p>
                </div>
            `;
            blockPolygon.bindPopup(blockPopupContent);
            blockPolygons.push({ blockId: block.id, polygon: blockPolygon });
        });

        // Função para alternar visibilidade dos blocks
        const toggleBlockVisibility = (blockId, isChecked) => {
            const block = blockPolygons.find(block => block.blockId === parseInt(blockId));
            if (block) {
                if (isChecked) {
                    block.polygon.addTo(map);
                } else {
                    map.removeLayer(block.polygon);
                }
            }
        };

        // Cria os polígonos para os lands
        const landPolygons = [];
        landsData.forEach(land => {
            const landCoordinates = land.coordinates.map(coord => coord.split(',').map(Number));
            const landPolygon = L.polygon(landCoordinates, {
                color: land.color || 'purple',
                fillColor: land.color || '#f0f',
                fillOpacity: 0.2
            }).addTo(map);

            const landPopupContent = `
                <div class="popup-content" style="font-family: Arial, sans-serif; color: #333;">
                    <h3>${land.name}</h3>
                    <p><strong>Área:</strong> ${land.area} m²</p>
                    <p><strong>Status:</strong> ${land.status}</p>
                    <p><strong>Código:</strong> ${land.code}</p>
                </div>
            `;
            landPolygon.bindPopup(landPopupContent);
            landPolygons.push({ landId: land.id, polygon: landPolygon });
        });

        // Função para alternar visibilidade dos lands
        const toggleLandVisibility = (landId, isChecked) => {
            const land = landPolygons.find(land => land.landId === parseInt(landId));
            if (land) {
                if (isChecked) {
                    land.polygon.addTo(map);
                } else {
                    map.removeLayer(land.polygon);
                }
            }
        };

        // Checkbox para a subdivisão
        const subdivisionToggle = document.getElementById('subdivision-toggle');
        if (subdivisionToggle) {
            subdivisionToggle.addEventListener('change', (event) => {
                if (event.target.checked) {
                    map.addLayer(polygon);
                } else {
                    map.removeLayer(polygon);
                }
            });
        }

        // Tratamento dos checkboxes dos blocks
        document.querySelectorAll('input[id^="block-"]').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                const blockId = event.target.id.replace('block-', '');
                toggleBlockVisibility(blockId, event.target.checked);
            });
        });

        // Garante que todos os blocks sejam exibidos inicialmente
        document.querySelectorAll('input[id^="block-"]').forEach(checkbox => {
            if (checkbox.checked) {
                const blockId = checkbox.id.replace('block-', '');
                toggleBlockVisibility(blockId, true);
            }
        });

        // Tratamento dos checkboxes dos lands
        document.querySelectorAll('input[id^="land-"]').forEach(checkbox => {
            checkbox.addEventListener('change', (event) => {
                const landId = event.target.id.replace('land-', '');
                toggleLandVisibility(landId, event.target.checked);
            });
        });

        // Garante que todos os lands sejam exibidos inicialmente
        document.querySelectorAll('input[id^="land-"]').forEach(checkbox => {
            if (checkbox.checked) {
                const landId = checkbox.id.replace('land-', '');
                toggleLandVisibility(landId, true);
            }
        });

    } else {
        console.error('Elemento do mapa não encontrado.');
    }
});
