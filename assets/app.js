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
global.$ = global.jQuery = $;

import '@popperjs/core';
import 'bootstrap';
import './styles/app.scss';
import './bootstrap';





$('.carousel').carousel();


/**
 * Permet d'afficher l'onglet d'une couleur différente
 * Ne marche que sur chrome Android
 * @returns Color
 */
function getRandomRGBValue() {
    return Math.min(Math.floor(Math.random() * 255 + 1), 255);
}

function getRandomColor() {
    var r = getRandomRGBValue(),
        g = getRandomRGBValue(),
        b = getRandomRGBValue();
    return "#" + (((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1));
}

function changeThemeColor() {
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", getRandomColor());
    setTimeout(function () {
        changeThemeColor();
    }, 3000);
}

changeThemeColor();


// function to set a given theme/color-scheme
function setTheme(themeName) {
    localStorage.setItem('theme', themeName);
    // récupére l'élément html themeName 
    document.documentElement.className = themeName;
}

// function to toggle between light and dark theme
function toggleTheme() {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-light');
    } else {
        setTheme('theme-dark');
    }
}

// Immediately invoked function to set the theme on initial load
(function () {
    if (localStorage.getItem('theme') === 'theme-dark') {
        setTheme('theme-dark');
    } else {
        setTheme('theme-light');
    }
})();

// start the Stimulus application
