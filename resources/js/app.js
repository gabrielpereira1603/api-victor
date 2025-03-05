import './bootstrap';
import flatpickr from "flatpickr";
import Alpine from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import './Calendar/Alert.js';
import './Subdivisions/create_subdivisions.js';
import  './Subdivisions/view_one_subdivision.js'
import './Blocks/create_blocks.js'
import 'leaflet-draw';
import 'leaflet-draw/dist/leaflet.draw.css';

// Adiciona Alpine ao escopo global
window.Alpine = Alpine;
Alpine.start();

// Adiciona Flatpickr ao escopo global
window.flatpickr = flatpickr;
window.L = L;

