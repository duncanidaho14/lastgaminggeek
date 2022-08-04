
import './img/android-chrome-192x192.png';
import './img/android-chrome-512x512.png';
import apple from './img/apple-touch-icon.png';
//import './img/browserconfig.xml';
import fav16 from './img/favicon-16x16.png';
import './img/favicon-32x32.png';
import './img/favicon.ico';
import './img/mstile-150x150.png';
import './img/safari-pinned-tab.svg';
// import './img/CV_2022-03-03_Elhadi_Beddarem.pdf';
//import './img/site.webmanifest';
import './styles/app.scss';
import userImage from './img/user-3331256.svg';
import jeuxvideo from './img/signal-3655575.svg';
import categories from './img/app-6702045.svg';
import comments from './img/comments-97860.svg';

import 'bootstrap';
import './js/jeux.js';
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


$('#add-categories').click(function(){
    // Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    // Je récupère le prototype des entrées
    const tmpl = $('#jeuxvideo_categories').data('prototype').replace(/__name__/g, index);

    // J'injecte ce code au sein de la div
    $('#jeuxvideo_categories').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // Je gère le bouton supprimer
    handleDeleteButtons();
});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function(){
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#jeuxvideo_categories div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();