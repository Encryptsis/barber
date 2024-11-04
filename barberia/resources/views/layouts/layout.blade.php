<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WILD DEER')</title>
    
    <!-- Incluir los archivos CSS compilados por Vite -->
    @vite(['resources/css/app.css', 'resources/css/acceso.css', 'resources/css/generales.css', 'resources/css/preloader.css'])

    <!-- Estilos específicos de cada página -->
    @yield('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand">WILD DEER BARBERSHOP & BAR</a>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active"><a class="nav-link" href="{{ url('/perfil/faciales') }}">Mi Perfil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/agenda/facial') }}">Mi Agenda</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="text-content">
                <span>PROPUESTA DE DISEÑO #1</span>
                <span>POR Alan Longoria</span>
            </div>
            <img src="{{ asset('images/logoO.jpeg') }}" class="footer-image">
        </div>
    </footer>

    <!-- Incluir los archivos JS compilados por Vite -->
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/index.js', 'resources/js/preloader.js'])
    
    <!-- Scripts específicos de cada página -->
    @yield('scripts')
</body>
</html>
