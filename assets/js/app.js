/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
//assets/js/app.js
//import 'bootstrap';

// any CSS you import will output into a single css file (app.css in this case)
//import '../css/app.css';

//On importe notre fichier global.scss
import './../css/global.scss'
//On ajoute jquery et le Javascript de Bootstrap
const $ = require('jquery');
require('bootstrap');

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});

// create global $ and jQuery variables
global.$ = global.jQuery = $;