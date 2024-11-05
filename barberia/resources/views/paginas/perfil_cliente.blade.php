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
        body {
            background-color: #f8f9fa;
            color: white;
        }
        .titulo-secciones {
            margin-top: 2rem;
            text-align: center;
        }
        .foto-barbero {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            margin-bottom: 1rem;
        }
        .info-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin: 0 auto;
            max-width: 400px;
        }
        .static-info {
            font-size: 1.2rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .info-bar, .navbar, footer {
            color: white;
        }
        .btn-edit {
            display: block;
            margin: 1rem auto;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
        }
        .btn-edit i {
            margin-right: 5px;
        }
        .edit-form {
            display: none; /* Ocultar el formulario por defecto */
            margin-top: 2rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
            border-radius: 10px;
            backdrop-filter: blur(10px);
        }
        .estrella {
            display: none; /* Ocultar inicialmente */
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 50px;
            color: gold; /* Color de la estrella */
            animation: brillar 1s infinite alternate;
        }

        @keyframes brillar {
            0% { opacity: 1; }
            100% { opacity: 0.5; }
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/agenda/cliente') }}">Mi Agenda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../index.html">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="secciones" style="margin-top: 3.5rem;">
        <h2 class="titulo-secciones">Perfil de Cliente</h2>
        <div class="text-center">
            <img src="../Imagenes/baber3.jpeg" alt="Foto del Cliente" class="foto-barbero" id="clienteFoto">
        </div>
        <div class="info-card">
            <div class="static-info" id="nombreCliente">
                <strong>Nombre del Cliente:</strong> Juan Pérez
            </div>
            <div class="static-info" id="correoCliente">
                <strong>Correo Electrónico:</strong> juan.perez@example.com
            </div>
            <div class="static-info" id="telefonoCliente">
                <strong>Teléfono:</strong> +34 123 456 789
            </div>
            <button class="btn-edit" id="editarPerfil">
                <i class="fas fa-edit"></i> Editar Perfil
            </button>
        </div>

        <!-- Formulario de edición -->
        <div class="edit-form" id="editForm">
            <h3 class="text-center">Editar Perfil</h3>
            <form id="formEdit">
                <div class="form-group">
                    <label for="nombreInput">Nombre del Cliente:</label>
                    <input type="text" class="form-control" id="nombreInput" placeholder="Ingrese el nombre" value="Juan Pérez">
                </div>
                <div class="form-group">
                    <label for="correoInput">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="correoInput" placeholder="Ingrese el correo electrónico" value="juan.perez@example.com">
                </div>
                <div class="form-group">
                    <label for="telefonoInput">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefonoInput" placeholder="Ingrese el número de teléfono" value="+34 123 456 789">
                </div>
                <div class="form-group">
                    <label for="fotoInput">Foto de Perfil:</label>
                    <input type="file" class="form-control" id="fotoInput">
                </div>
                <button type="button" class="btn btn-primary" id="guardarCambios">Guardar Cambios</button>
                <button type="button" class="btn btn-secondary" id="cancelarEdicion">Cancelar</button>
            </form>
        </div>
    </section>


   
    <div class="estrella" id="estrella">&#9733;</div> <!-- Estrella brillante -->

    
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
        document.getElementById('editarPerfil').addEventListener('click', function() {
            document.getElementById('editForm').style.display = 'block'; // Mostrar el formulario
        });

        document.getElementById('guardarCambios').addEventListener('click', function() {
            const nombre = document.getElementById('nombreInput').value;
            const correo = document.getElementById('correoInput').value;
            const telefono = document.getElementById('telefonoInput').value;
            const foto = document.getElementById('fotoInput').files[0];

            // Actualizar la información en la tarjeta
            document.getElementById('nombreCliente').innerHTML = `<strong>Nombre del Cliente:</strong> ${nombre}`;
            document.getElementById('correoCliente').innerHTML = `<strong>Correo Electrónico:</strong> ${correo}`;
            document.getElementById('telefonoCliente').innerHTML = `<strong>Teléfono:</strong> ${telefono}`;

            // Si se ha seleccionado una nueva foto, actualizarla
            if (foto) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('clienteFoto').src = e.target.result; // Cambiar la imagen
                }
                reader.readAsDataURL(foto);
            }

            // Ocultar el formulario después de guardar
            document.getElementById('editForm').style.display = 'none';
        });

        document.getElementById('cancelarEdicion').addEventListener('click', function() {
            document.getElementById('editForm').style.display = 'none'; // Ocultar el formulario
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si el premio está disponible
            if (localStorage.getItem('premioDisponible') === 'true') {
                document.getElementById('estrella').style.display = 'block'; // Mostrar estrella
                localStorage.removeItem('premioDisponible'); // Eliminar estado para que no vuelva a aparecer
            }
        });
    </script>
</body>

</html>


