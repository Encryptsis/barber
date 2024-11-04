// resources/js/preloader.js

function carga() {
    const preloader = document.getElementById('preloader');
    if (preloader) {
        preloader.classList.add('hidden'); // Añade la clase "hidden" para activar el desvanecimiento
    }
}

// Ejecuta la función carga cuando la página termine de cargar
window.addEventListener('load', carga);
