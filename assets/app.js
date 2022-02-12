
import './img/android-chrome-192x192.png';
import './img/android-chrome-512x512.png';
import apple from './img/apple-touch-icon.png';
//import './img/browserconfig.xml';
import fav16 from './img/favicon-16x16.png';
import './img/favicon-32x32.png';
import './img/favicon.ico';
import './img/mstile-150x150.png';
import './img/safari-pinned-tab.svg';
//import './img/site.webmanifest';
import './styles/app.scss';
// $('.dropdown-toggle').dropdown();
// $('.carousel').carousel();

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
