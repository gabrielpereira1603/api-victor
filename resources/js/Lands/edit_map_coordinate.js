import L from "leaflet";
import "leaflet-draw";

document.addEventListener("DOMContentLoaded", () => {
    Livewire.on("loadMapData", (data) => {
        console.log("Dados carregados do Livewire:", data[0]); // Debugging: Verificar os dados recebidos

        if (data[0].land && data[0].land.first_coordinate) {
            initializeMap(data[0].land, data[0].block, data[0].otherLands, data[0].land.first_coordinate);
        } else {
            console.error("Erro: first_coordinate não encontrado ou indefinido.");
        }
    });
});

let map; // Variável para armazenar o mapa globalmente

function initializeMap(editedLand, block, otherLands, firstCoordinate) {
    console.log("Iniciando a função initializeMap"); // Debugging: Verificar quando a função é chamada
    console.log("Primeira coordenada recebida:", firstCoordinate); // Debugging: Verificar a coordenada inicial

    if (!firstCoordinate) {
        console.error("Erro: first_coordinate não está definido.");
        return;
    }

    const firstCoord = typeof firstCoordinate === "string"
        ? firstCoordinate.split(",").map(parseFloat)
        : firstCoordinate;

    console.log("Coordenada convertida:", firstCoord); // Debugging: Verificar a conversão das coordenadas

    // Se o mapa já existir, destrua-o primeiro
    if (map) {
        map.remove();
    }

    // Criar mapa
    map = L.map("map-edit-coordinate-lands", {
        center: firstCoord,
        zoom: 18,
        minZoom: 15,
        maxZoom: 22,
    });

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap Contributors",
    }).addTo(map);

    console.log("Mapa criado com sucesso"); // Debugging: Confirmar a criação do mapa

    const drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    const drawControl = new L.Control.Draw({
        edit: { featureGroup: drawnItems, remove: true },
        draw: { polygon: { color: "red", weight: 3 }, rectangle: false, circle: false, marker: false, polyline: false },
    });

    map.addControl(drawControl);

    // Adiciona o terreno editado
    if (editedLand.coordinates) {
        const editedPolygon = L.polygon(editedLand.coordinates, {
            color: "red",
            weight: 3,
            fillColor: "#FF0000",
            fillOpacity: 0.6,
        }).addTo(map);
        drawnItems.addLayer(editedPolygon);
        console.log("Terreno editado adicionado ao mapa"); // Debugging: Verificar se o terreno foi adicionado
    }

    // Exibir o quarteirão (Block)
    if (block.coordinates && block.coordinates.length > 0) {
        L.polygon(block.coordinates, {
            color: "green",
            weight: 2,
            fillColor: "#90EE90",
            fillOpacity: 0.4,
        }).addTo(map).bindPopup(`<strong>Quarteirão:</strong> ${block.name}`);
        console.log("Quarteirão adicionado ao mapa"); // Debugging: Verificar se o quarteirão foi adicionado
    }

    // Exibir outros terrenos do mesmo quarteirão
    if (otherLands && otherLands.length > 0) {
        otherLands.forEach((land) => {
            if (land.coordinates) {
                L.polygon(land.coordinates, {
                    color: "blue",
                    weight: 2,
                    fillColor: "#ADD8E6",
                    fillOpacity: 0.5,
                }).addTo(map).bindPopup(`<strong>Terreno:</strong> ${land.name}`);
                console.log(`Terreno ${land.name} adicionado ao mapa`); // Debugging: Verificar se o terreno foi adicionado
            }
        });
    }

    // Eventos de edição e criação
    map.on(L.Draw.Event.CREATED, (event) => {
        const layer = event.layer;
        drawnItems.addLayer(layer);
        const newCoordinates = layer.getLatLngs()[0].map((latlng) => [latlng.lat, latlng.lng]);
        console.log("Novas coordenadas:", newCoordinates); // Debugging: Verificar as coordenadas após criação
        Livewire.dispatch("updateCoordinates", { coordinates: newCoordinates });
    });

    map.on(L.Draw.Event.EDITED, (event) => {
        event.layers.eachLayer((layer) => {
            const updatedCoordinates = layer.getLatLngs()[0].map((latlng) => [latlng.lat, latlng.lng]);
            console.log("Coordenadas editadas:", updatedCoordinates); // Debugging: Verificar as coordenadas após edição
            Livewire.dispatch("updateCoordinates", { coordinates: updatedCoordinates });
        });
    });

    // Ajuste o tamanho do mapa
    map.invalidateSize();
}
