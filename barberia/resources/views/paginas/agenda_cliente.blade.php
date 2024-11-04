<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WILD DEER</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../CSS/generales.css">
    <link rel="stylesheet" href="../CSS/preloader.css">
    <link href='https://unpkg.com/fullcalendar@5.10.1/main.css' rel='stylesheet' />
    <style>
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
                    <a class="nav-link" href="perfil_cliente.html">Mi Perfil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="agenda_cliente.html">Mi Agenda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.html">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.html">Cerrar Sesion</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="secciones" style="margin-top: 3.5rem;">
        <h2 class="titulo-secciones">AGENDAR CITA</h2>
        <div id="appointmentForm" class="mt-4" style="display:none;">
            <h4 class="form-label">Detalles de Cita</h4>
            <form id="formDetails">
                <input type="hidden" id="selectedDate">
                <div class="form-group">
                    <label for="attendant" class="form-label">Seleccionar Persona</label>
                    <select class="form-control" id="attendant" required>
                        <option value="">Seleccionar...</option>
                        <option value="barbero1">Barbero 1</option>
                        <option value="barbero2">Barbero 2</option>
                        <option value="facialista">Facialista</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="service" class="form-label">Seleccionar Servicio</label>
                    <select class="form-control" id="service" required>
                        <option value="">Seleccionar...</option>
                        <option value="Corte">Corte</option>
                        <option value="Afeitado">Afeitado</option>
                        <option value="Facial">Facial</option>
                        <option value="Masaje">Masaje</option>
                        <option value="Tinte">Tinte</option>
                        <option value="Corte de Cabello">Corte de Cabello</option>
                        <option value="Corte de Barba">Corte de Barba</option>
                        <option value="Estilo">Estilo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Agendar Cita</button>
            </form>
            <div id="confirmationMessage" class="mt-3"></div>
        </div>

        <div id="calendar"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://unpkg.com/fullcalendar@5.10.1/main.js'></script>
    <script src="../JavaScript/preloader.js"></script>
    <script src="../JavaScript/index.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const events = []; // Arreglo para almacenar las citas agendadas

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // Ver horas
                allDaySlot: false, // Ocultar slot de todo el día
                slotDuration: '00:45:00', // Duración de las citas
                slotMinTime: '11:00:00', // Hora mínima
                slotMaxTime: '20:00:00', // Hora máxima
                events: events,
                nowIndicator: true, // Indicador de hora actual
                validRange: {
                    start: new Date() // Solo mostrar desde hoy en adelante
                },
                dateClick: function(info) {
                    // Verificar si ya hay una cita en esta franja horaria
                    const hasEvent = events.some(event => {
                        return event.start <= info.date && event.end >= info.date;
                    });

                    if (!hasEvent && (info.date.getHours() < 19 || (info.date.getHours() === 19 && info.date.getMinutes() <= 15))) {

                        document.getElementById('selectedDate').value = info.dateStr;
                        document.getElementById('appointmentForm').style.display = 'block';
                    } else {
                        alert('Ya hay una cita agendada en este horario.');
                    }
                },
                eventClick: function(info) {
                    if (confirm('¿Deseas eliminar esta cita?')) {
                        info.event.remove(); // Eliminar evento del calendario
                    }
                },
                eventAdd: function(info) {
                    // Cambiar el color a verde
                    info.event.setProp('backgroundColor', 'green');
                }
            });
            calendar.render();

            document.getElementById('formDetails').addEventListener('submit', function(event) {
                event.preventDefault();
                
                const selectedDate = document.getElementById('selectedDate').value;
                const attendant = document.getElementById('attendant').value;
                const service = document.getElementById('service').value;
                 
                if ((attendant === 'facialista' && service !== 'Facial') || 
                 ((attendant === 'barbero1' || attendant === 'barbero2') && service === 'Facial')) {
                  alert('La facialista solo puede recibir citas para faciales y los barberos no pueden agendar faciales.');
                   return; // Evita enviar el formulario si la condición no se cumple
}

                const eventObj = {
                    title: `${service} con ${attendant}`,
                    start: selectedDate,
                    end: new Date(new Date(selectedDate).getTime() + 45 * 60000), // Duración de 45 minutos
                };

                events.push(eventObj); // Agregar evento

                events.push(eventObj); // Agregar evento al arreglo
                calendar.addEvent(eventObj); // Añadir el evento al calendario

                const confirmationMessage = document.getElementById('confirmationMessage');
                confirmationMessage.innerHTML = `<div class="alert alert-success">Cita agendada para ${selectedDate} con ${attendant}. Servicio: ${service}.</div>`;
                
                document.getElementById('appointmentForm').style.display = 'none';
            });
        });
    </script>
</body>

</html>
