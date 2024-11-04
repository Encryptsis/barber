<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Cliente - WILD DEER</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/generales.css">
    <link rel="stylesheet" href="../CSS/preloader.css">
    <style>
          body {
            background-color: #f8f9fa;
            color: white; /* Cambiar el color del texto a blanco */
        }
        .titulo-secciones {
            margin-top: 2rem;
        }
        .foto-barbero {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
        .info-bar, .navbar, footer {
            color: white; /* Asegura que el texto de estos elementos también sea blanco */
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
                    <a class="nav-link" href="../../index.html">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="secciones" style="margin-top: 3.5rem;">
        <h2 class="titulo-secciones">Perfil del Cliente</h2>
        <form id="perfilClienteForm">
            <div class="form-group">
                <label for="nombre">Nombre del Cliente:</label>
                <input type="text" class="form-control" id="nombre" placeholder="Ingrese el nombre">
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico:</label>
                <input type="email" class="form-control" id="correo" placeholder="Ingrese el correo electrónico">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="tel" class="form-control" id="telefono" placeholder="Ingrese el número de teléfono">
            </div>
            <div class="form-group">
                <label for="paypal">Cuenta de PayPal:</label>
                <input type="text" class="form-control" id="paypal" placeholder="Ingrese la cuenta de PayPal">
            </div>
            <button type="button" class="btn btn-primary" id="guardarPerfil">Guardar Perfil</button>
            <button type="button" class="btn btn-secondary" id="agendar">Agendar Cita</button>
        </form>
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
    <script>
        // Funcionalidad para guardar el perfil del cliente
        document.getElementById('guardarPerfil').addEventListener('click', function() {
            const nombre = document.getElementById('nombre').value;
            const correo = document.getElementById('correo').value;
            const telefono = document.getElementById('telefono').value;
            const paypal = document.getElementById('paypal').value;

            // Aquí podrías agregar lógica para guardar estos datos en una base de datos o localStorage
            alert(`Perfil guardado:\nNombre: ${nombre}\nCorreo: ${correo}\nTeléfono: ${telefono}\nPayPal: ${paypal}`);
        });

        // Funcionalidad para agendar cita
        document.getElementById('agendar').addEventListener('click', function() {
            window.location.href = 'agenda_cliente.html'; // Redirigir a la página de agendar cita
        });
    </script>
</body>

</html>
