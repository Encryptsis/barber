<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WILD DEER</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <!-- Archivos CSS Compilados con Vite -->
    @vite(['resources/css/generales.css', 'resources/css/preloader.css'])
 <!-- Estilos para el Preloader usando la URL generada por Vite -->
  
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
            .loader {
                background-image: url("{{ Vite::asset('public/Imagenes/logoO.jpeg') }}");
                width: 100%;
                height: 100%;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover; /* Ajusta para cubrir completamente la pantalla */
            }
        </style>
    <!--Vite::asset('resources/Imagenes/logoO.jpeg') }}-->
</head>

<body onload="setTimeout(carga, 100)">
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <!-- Barra de Información -->
    <div class="info-bar">
        <span>MON - SUN: 11.00 A.M. - 08.00 P.M.</span>
        <div class="social-icons">
            <a href="https://www.facebook.com/wilddeerbarbershopandbar?_rdr"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.instagram.com/wilddeerbarbershopandbar/"><i class="fab fa-instagram"></i></a>
            <a href="https://www.tiktok.com/@wilddeerbarbershop"><i class="fab fa-tiktok"></i></a>
        </div>
    </div>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand">WILD DEER BARBERSHOP & BAR</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/registro') }}">Registrarme</a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- Imagen Principal -->
    <img src="{{ asset('Imagenes/wildbeer_barbershp&bar.jpeg') }}" class="hero-image" alt="Wild Deer">

    <!-- Secciones de Contenido -->
    <section class="secciones">
        <h2 class="titulo-secciones"><i class="bi bi-file-person-fill"></i> THE DEER TEAM</h2>
        <div class="partes">
            <section class="slider-container">
                <div class="slider-images">
                    <div class="slider-img">
                        <img src="{{ asset('Imagenes/Minael.jpg') }}" alt="Minael" />
                        <div class="overlay"></div>
                        <h1 class="car">INNOVATION</h1>
                        <div class="details">
                            <h2 class="car2">Minael</h2>
                            <p class="car3">Avant-garde Style</p>
                        </div>
                    </div>

                    <div class="slider-img active">
                        <img src="{{ asset('Imagenes/MichaelAguilar.jpeg') }}" alt="Michael Aguilar" />
                        <div class="overlay"></div>
                        <h1 class="car">PRESICION</h1>
                        <div class="details">
                            <h2 class="car2">MICHAEL AGUILAR</h2>
                            <p class="car3">Master Touch</p>
                        </div>
                    </div>

                    <div class="slider-img">
                        <img src="{{ asset('Imagenes/baber3.jpeg') }}" alt="Harold" />
                        <div class="overlay"></div>
                        <h1 class="car">CREATIVITY</h1>
                        <div class="details">
                            <h2 class="car2">HAROLD</h2>
                            <p class="car3">We capture your identity</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

    <!-- Servicios -->
    <section class="secciones">
    <h2 class="titulo-secciones"><i class="bi bi-cash-stack"></i> SERVICES WE OFFER</h2>
    <div class="partes">

        <div class="carrusel">
            <div class="carrusel-inner">
                <!-- Repetir tarjetas de servicio -->
                @foreach ([
                    [
                        'title' => 'HAIRCUT',
                        'description' => 'Get the haircut you want with our expert stylist. Whether it’s a classic style or something unique, just bring a picture, and we’ll create the look you desire.',
                        'price' => '40 min. $35.00',
                        'link' => 'https://buy.stripe.com/test_14k9E334m0k75fGeUU',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'FULL CUT',
                        'description' => 'Experience our original full haircut package: A premium grooming service that includes a precise haircut, detailed beard shaping, and eyebrow trimming.',
                        'price' => '1 hour. $60.00',
                        'link' => 'https://buy.stripe.com/test_3csdUjeN41obgYo001',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'KIDS',
                        'description' => 'We welcome kids for haircuts! For their comfort and safety, we recommend parent and adult supervision for those who are a bit more active.',
                        'price' => '30 min. $35.00',
                        'link' => 'https://buy.stripe.com/test_6oEaI77kCaYL6jK28a',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'BEARD GROOMING',
                        'description' => 'We offer precise line-ups, shaping, trimming, and shaving. Enjoy a hot towel treatment and relaxing oil for a refreshing experience.',
                        'price' => '30 min. $30.00',
                        'link' => 'https://buy.stripe.com/test_bIY6rR9sK4AnfUk28b',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'WILD CUT',
                        'description' => 'Come and live the Wild Deer experience, a service in personal care and well-being, leaving you feeling renewed, confident, and ready for any adventure.',
                        'price' => '1 hour 30 min. $115.00',
                        'link' => 'https://buy.stripe.com/test_7sI17xdJ05Er8rSeUY',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'FACIAL',
                        'description' => 'We apply masks rich in natural ingredients to deeply nourish and hydrate the skin. This mask, inspired by the purity of nature, returns luminosity and elasticity to your face.',
                        'price' => '30 min. $55.00',
                        'link' => 'https://buy.stripe.com/test_9AQ17xdJ0aYL37y28d',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'LINE UP',
                        'description' => 'Defining the lines of the forehead, sideburns, and nape, creating a symmetrical and polished finish.',
                        'price' => '30 min. $40.00',
                        'link' => 'https://buy.stripe.com/test_8wM5nNfR86Iv23u6ou',
                        'img' => 'barberia.jpg'
                    ],
                    [
                        'title' => 'HYDROGEN OXYGEN',
                        'description' => 'A non-invasive skin care procedure that uses a special device to deliver a mixture of hydrogen gas and oxygen to the skin for deeply cleansing pores and reducing imperfections.',
                        'price' => '1 hour. $140.00',
                        'link' => 'https://buy.stripe.com/test_14kcQf8oGgj50ZqdQX',
                        'img' => 'barberia.jpg'
                    ],
                    // Puedes agregar más servicios siguiendo este formato
                ] as $service)
                    <div class="card">
                        <img src="{{ asset('Imagenes/' . $service['img']) }}" alt="{{ $service['title'] }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $service['title'] }}</h5>
                            <p class="card-text">{{ $service['description'] }}</p>
                            <p class="card-text">{{ $service['price'] }}</p>
                            <a href="{{ $service['link'] }}" target="_blank">
                                <img src="{{ asset('Imagenes/pagar.png') }}" alt="Pagar" style="width: 150px; height: auto;">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="prev" onclick="moveSlide(-1)">&#10094;</button>
            <button class="next" onclick="moveSlide(1)">&#10095;</button>
        </div>

    </div>
</section>


    <!-- Espacio de Trabajo -->
    <section class="secciones">
        <h2 class="titulo-secciones"><i class="bi bi-scissors"></i> OUR WORKSPACE</h2>
        <div class="partes">
            <img src="{{ asset('Imagenes/workspace.jpg') }}" class="hero-image" alt="Workspace">
        </div>
    </section>

    <!-- Nuestro Trabajo (Video) -->
    <section class="secciones">
        <h2 class="titulo-secciones"><i class="bi bi-play-btn"></i> OUR WORK</h2>
        <div class="partes">
            <div class="video-container">
                <iframe src="https://www.youtube.com/embed/dig_n1ryyWI?si=5NncztdVKXDki9EL" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </section>

    <!-- Información Adicional -->
    <section class="secciones">
        <div class="partes">
            <div class="contenedor_elementos">
                <div class="wild_deer_info">
                    <div class="info info-1">
                        <h2>OUR LOCATIONS</h2>
                        <hr>
                        <p>7111 NW 86th St, Kansas City, 64153</p>
                        <hr>
                        <h2>WE´RE OPEN FROM MONDAY TO FRIDAY</h2>
                        <hr>
                        <p>Contact By Email: wilddeer@gmail.com</p>
                        <p>Contact By Cell Number: 434-000-0000</p>
                    </div>
                    <div class="info info-2">
                        <img src="{{ asset('Imagenes/slogan_imagen.jpg') }}" alt="Slogan Image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa de Ubicación -->
    <section class="secciones">
        <h2 class="titulo-secciones"><i class="bi bi-pin-map-fill"></i> VISIT US!</h2>
        <div class="partes">
            <div class="contenedor_elementos">
                <iframe class="mapa"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509847!2d-94.7052346846815!3d39.22990397941769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87c0a8b6a7e9c7c7%3A0x8e4b7a5e5f4a5b9!2s7111%20NW%2086th%20St%2C%20Kansas%20City%2C%20MO%2064153%2C%20Estados%20Unidos!5e0!3m2!1ses-419!2ses-419!4v1697123456789"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </section>

    <!-- Botones Flotantes -->
    <section>
        <button id="scrollToTopBtn" class="scroll-to-top fa fa-arrow-up" onclick="scrollToTop()">
        </button>

        <button class="float-wa fa fa-whatsapp" onclick="openWhatsApp()">
        </button>
    </section>

    <!-- Pie de Página -->
    <footer>
        <div class="footer-content">
            <div class="text-content">
                <span>PROPUESTA DE DISEÑO #1</span>
                <span>POR ALAN LONGORIA</span>
            </div>
            <img src="{{ asset('Imagenes/logoO.jpeg') }}" class="footer-image" alt="Logo Wild Deer">
        </div>
    </footer>

    <!-- Scripts -->
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Archivos JS Compilados con Vite -->
    @vite(['resources/js/preloader.js', 'resources/js/index.js'])
</body>

</html>
