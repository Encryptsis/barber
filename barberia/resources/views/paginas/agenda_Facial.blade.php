<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WILD DEER - Facial</title>
    
    <!-- Bootstrap 4.5.2 CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome 5.15.3 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <!-- FullCalendar CSS -->
    <link href='https://unpkg.com/fullcalendar@5.10.1/main.css' rel='stylesheet' />
    
    <!-- Archivos CSS personalizados compilados con Vite -->
    @vite(['resources/css/generales.css', 'resources/css/preloader.css'])
    
    <style>
        body {
                margin: 0;
                font-family: Cambria, Georgia, serif;
                background-image: url("{{ Vite::asset('public/Imagenes/background.jpeg') }}"); 
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;
            }   
        /* Estilos personalizados */
         /* Estilos personalizados */
         .fc-toolbar h2 {
            color: white; /* Texto del mes */
        }
        .form-label {
            color: white; /* Texto de los labels */
        }
        #calendar {
            max-width: 900px; /* Tamaño del calendario */
            margin: auto;
            max-height: 400px;
        }
        .fc-event {
            background-color: green; /* Color de las citas agendadas */
        }
        .fc {
            background-color: #5a6978; /* Color de fondo del calendario */
        }
        .fc-time-grid .fc-slot {
            height: 45px; /* Altura uniforme para los intervalos de hora */
        }
        .fc-time-grid .fc-slot[data-time="06:30:00"] {
            height: 45px; /* Ajuste de altura para las 6:30 PM */
        }
        @media (max-width: 768px) {
            #calendar {
                width: 100%; /* Hacer el calendario responsive */
            }
        }
    </style>
</head>

<body>

    <div class="info-bar">
        <span>MON - SUN: 11.00 A.M. - 08.00 P.M.</span>
        <div class="social-icons">
            <a href="https://www.facebook.com/wilddeerbarbershopandbar?_rdr"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/wilddeerbarbershopandbar/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@wilddeerbarbershop"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand">WILD DEER BARBERSHOP & BAR</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/perfil/faciales') }}">Mi Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.html">Cerrar Sesion</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="secciones" style="margin-top: 3.5rem;">
        <h2 class="titulo-secciones">CITAS AGENDADAS</h2>
        <div id="calendar" style="max-width: 900px; margin: auto;"></div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="text-content">
                <span>PROPUESTA DE DISEÑO #1</span>
                <span>POR Alan Longoria</span>
            </div>
            <img src="{{ asset('Imagenes/logoO.jpeg') }}" class="footer-image" alt="Logo Wild Deer">

        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src='https://unpkg.com/fullcalendar@5.10.1/main.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const events = [
                // Aquí se deberían cargar las citas ya agendadas por los clientes
                {
                    title: 'Corte con Barbero 1',
                    start: '2024-11-03T11:00:00',
                    end: '2024-11-03T11:45:00'
                },
                {
                    title: 'Afeitado con Barbero 2',
                    start: '2024-11-03T12:00:00',
                    end: '2024-11-03T12:45:00'
                },
                // Más eventos pueden ser añadidos aquí
            ];

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                allDaySlot: false,
                slotDuration: '01:00:00',
                slotMinTime: '11:00:00',
                slotMaxTime: '20:00:00',
                events: events,
                nowIndicator: true,
                validRange: {
                    start: new Date() // Solo mostrar desde hoy en adelante
                },
                eventClick: function(info) {
                    if (confirm('¿Deseas eliminar esta cita?')) {
                        info.event.remove(); // Eliminar evento del calendario
                    }
                }
            });
            calendar.render();
        });
    </script>
</body>

</html>
