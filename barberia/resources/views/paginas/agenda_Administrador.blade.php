<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WILD DEER - Administración</title>

    <!-- Bootstrap 4.5.2 CSS desde CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 5.15.3 desde CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Bootstrap Icons desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <!-- FullCalendar CSS desde CDN -->
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
        body {
            color: white; /* Color del texto */
        }
        .fc-toolbar h2 {
            color: white; /* Texto del mes */
        }
        .form-label {
            color: white; /* Texto de los labels */
        }
        .progress {
            height: 20px;
        }
        #calendar {
            max-width: 900px; /* Tamaño del calendario */
            margin: auto;
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ url('/perfil/administrador') }}">Mi Perfil</a>
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
        <div class="row">
            <div class="col-md-4">
                <h4>Agenda Barbero 1</h4>
                <div id="calendar1" class="calendar"></div>
            </div>
            <div class="col-md-4">
                <h4>Agenda Barbero 2</h4>
                <div id="calendar2" class="calendar"></div>
            </div>
            <div class="col-md-4">
                <h4>Agenda Barbero 3</h4>
                <div id="calendar3" class="calendar"></div>
            </div>
        </div>

        <h2 class="titulo-secciones" style="margin-top: 2rem;">Sistema de Puntos</h2>
        <div class="form-group">
            <label for="cliente">Seleccionar Cliente:</label>
            <select class="form-control" id="cliente">
                <option>Cliente 1</option>
                <option>Cliente 2</option>
                <option>Cliente 3</option>
            </select>
        </div>
        <div class="form-group">
            <label for="puntos">Puntos Acumulados:</label>
            <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%;" id="puntosBarra">0%</div>
            </div>
            <button class="btn btn-primary" id="agregarPuntos">Agregar Puntos</button>
            <button class="btn btn-success" id="reclamarPremio" disabled>Reclamar Premio</button>
        </div>

        <h2 class="titulo-secciones" style="margin-top: 2rem;">Generar Multa</h2>
        <div class="form-group">
            <label for="clienteMulta">Seleccionar Cliente:</label>
            <select class="form-control" id="clienteMulta">
                <option>Cliente 1</option>
                <option>Cliente 2</option>
                <option>Cliente 3</option>
            </select>
        </div>
        <div class="form-group">
            <label for="servicio">Valor del Servicio:</label>
            <input type="number" class="form-control" id="servicio" placeholder="Ingrese el valor del servicio">
        </div>
        <button class="btn btn-danger" id="generarMulta">Generar Multa</button>
        <button class="btn btn-warning" id="aplicarMulta" disabled>Aplicar Multa</button>

        <h2 class="titulo-secciones" style="margin-top: 2rem;">Cobrar Multa</h2>
        <div class="form-group">
            <label for="multaCobro">Monto de la Multa:</label>
            <input type="text" class="form-control" id="multaCobro" readonly>
        </div>
        <div id="paypal-button-container"></div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="text-content">
                <span>PROPUESTA DE DISEÑO #1</span>
                <span>POR Alan Longoria</span>
            </div>
            <img src="../Imagenes/logoO.jpeg" class="footer-image">
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src='https://unpkg.com/fullcalendar@5.10.1/main.js'></script>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID"></script> <!-- Reemplaza con tu Client ID de PayPal -->

    <script>
        const calendars = [
            { id: 'calendar1', events: [] },
            { id: 'calendar2', events: [] },
            { id: 'calendar3', events: [] },
        ];

        document.addEventListener('DOMContentLoaded', function() {
            calendars.forEach(calendar => {
                const calendarEl = document.getElementById(calendar.id);
                const fullCalendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'timeGridWeek',
                    allDaySlot: false,
                    slotDuration: '00:45:00',
                    slotMinTime: '11:00:00',
                    slotMaxTime: '20:00:00',
                    events: calendar.events,
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
                fullCalendar.render();
            });

            let multaActual = 0;

            document.getElementById('agregarPuntos').addEventListener('click', function() {
                const barra = document.getElementById('puntosBarra');
                let puntos = parseInt(barra.style.width);
                if (puntos < 100) {
                    puntos += 10; // Incrementar puntos
                    if (puntos > 100) puntos = 100; // No sobrepasar 100%
                    barra.style.width = puntos + '%';
                    barra.innerText = puntos + '%';
                }
                // Habilitar botón de reclamar premio si llega al 100%
                document.getElementById('reclamarPremio').disabled = (puntos < 100);
            });

            document.getElementById('reclamarPremio').addEventListener('click', function() {
                alert('¡Felicidades! Has reclamado tu premio. La barra de puntos se reiniciará.');
                // Reiniciar barra de puntos
                const barra = document.getElementById('puntosBarra');
                barra.style.width = '0%';
                barra.innerText = '0%';
                this.disabled = true; // Deshabilitar botón nuevamente
            });

            document.getElementById('generarMulta').addEventListener('click', function() {
                const cliente = document.getElementById('clienteMulta').value;
                const valor = document.getElementById('servicio').value;
                if (valor) {
                    multaActual = (valor * 0.20).toFixed(2); // Calcula el 20% de la multa
                    document.getElementById('multaCobro').value = `${multaActual} USD`;
                    document.getElementById('aplicarMulta').disabled = false; // Habilitar botón de aplicar multa
                    initPayPalButton(multaActual); // Inicializa el botón de PayPal
                }
            });

            document.getElementById('aplicarMulta').addEventListener('click', function() {
                alert(`La multa de ${multaActual} USD ha sido aplicada al cliente ${document.getElementById('clienteMulta').value}.`);
                // Aquí puedes agregar la lógica para registrar la multa en el sistema
                document.getElementById('multaCobro').value = ''; // Limpiar campo de multa
                this.disabled = true; // Deshabilitar botón después de aplicar
            });

            function initPayPalButton(amount) {
                // Limpiar el contenedor del botón antes de renderizar
                document.getElementById('paypal-button-container').innerHTML = '';

                paypal.Buttons({
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: amount // Monto de la multa
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                            alert('Pago exitoso: ' + details.id);
                            // Aquí puedes agregar la lógica para actualizar el estado de la multa
                        });
                    },
                    onError: function(err) {
                        console.error(err);
                        alert('Ha ocurrido un error en el pago. Intenta de nuevo.');
                    }
                }).render('#paypal-button-container'); // Renderizar el botón de PayPal
            }

        });
    </script>
</body>

</html>
