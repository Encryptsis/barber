// Navbar cambia de estilo al hacer scroll
window.addEventListener('scroll', function () {
    const navbar = document.querySelector('.navbar');
    if (navbar) {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }
});

// Mostrar/Ocultar botón "scroll to top"
/*
var scrollToTopBtn = document.getElementById("scrollToTopBtn");

if (scrollToTopBtn) {
    // Mostrar el botón cuando el usuario se desplaza hacia abajo
    window.onscroll = function () { scrollFunction() };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    }

    // Desplazarse hacia la parte superior al hacer clic en el botón
    scrollToTopBtn.addEventListener("click", function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
} */

// Slider: cambiar imagen activa al hacer clic
jQuery(document).ready(function ($) {
    $(".slider-img").on("click", function () {
        $(".slider-img").removeClass("active");
        $(this).addClass("active");
    });
});

// Abrir WhatsApp en una nueva pestaña
function openWhatsApp() {
    window.open('https://wa.me/NUMBER?text=Saludos', '_blank');
}

// Definir el número de tarjetas visibles
let currentIndex = 0;
const cardsToShow = 3; // Número de tarjetas que deseas mostrar a la vez

function moveSlide(direction) {
    const slides = document.querySelectorAll('.services-section .carrusel-inner .card');
    const carruselInner = document.querySelector('.services-section .carrusel-inner');

    if (slides.length === 0 || !carruselInner) return; // Verificar que los elementos existen

    const maxIndex = slides.length - cardsToShow;

    // Calcular el nuevo índice
    const newIndex = currentIndex + direction * cardsToShow;

    // Limitar el índice para que no sobrepase el rango
    currentIndex = Math.min(Math.max(newIndex, 0), maxIndex);

    // Calcular el desplazamiento en función del ancho de las tarjetas y el margen
    const offset = -currentIndex * (slides[0].clientWidth + 30); // Ajuste por el margen entre tarjetas
    carruselInner.style.transform = `translateX(${offset}px)`;
}

// Eventos para los botones de navegación
document.querySelector('.services-section .prev').addEventListener('click', () => moveSlide(-1));
document.querySelector('.services-section .next').addEventListener('click', () => moveSlide(1));
