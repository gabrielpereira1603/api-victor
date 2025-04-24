import './bootstrap';
import flatpickr from "flatpickr";
import A from 'alpinejs';
import L from 'leaflet';
import 'leaflet/dist/leaflet.css';
import './Calendar/Alert.js';
import './Subdivisions/create_subdivisions.js';
import  './Subdivisions/view_one_subdivision.js'
import './Blocks/create_blocks.js'
import './Lands/create_lands.js'
import './Lands/edit_lands.js'
import 'leaflet-draw';
import "leaflet/dist/leaflet.css";
import "leaflet-draw/dist/leaflet.draw.css";
import "leaflet-snap";
import "leaflet-geometryutil";

// Adiciona Alpine ao escopo global
window.A = A;
A.start();

// Adiciona Flatpickr ao escopo global
window.flatpickr = flatpickr;
window.L = L;


