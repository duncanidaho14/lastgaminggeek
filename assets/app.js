/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)


// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything

// or you can include specific pieces
import $ from 'jquery';
import '@popperjs/core';
import 'bootstrap';
import './styles/app.scss';
import './bootstrap';
import './styles/header.scss';
import './styles/app.scss';




$('.carousel').carousel()

// start the Stimulus application
