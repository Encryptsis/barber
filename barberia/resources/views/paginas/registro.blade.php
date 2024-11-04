<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WILD DEER</title>

    <!-- Bootstrap CSS desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">   

    <!-- Bootstrap Icons desde CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">   

    <!-- Archivo CSS personalizado compilado con Vite -->
    @vite(['resources/css/acceso.css'])
</head>


<body>

    <div class="wrapper">
        <div class="auth-content">
            <div class="card">
                <div class="card-body">
                    <div class="mb-4">
                        <p class="titulo">BIENVENIDO, REGISTRATE</p>
                    </div>
                    <form action="../../index.html" method="POST" autocomplete="on">
                        
                        <div class="form-group">
                            <label for="usuario">Usuario:</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>

                        <div class="form-group">
                            <label for="clave">Clave:</label>
                            <input type="password" class="form-control" name="clave" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="nombre_cliente">Nombre Completo:</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_cliente">Número de Teléfono:</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="correo_cliente">Correo:</label>
                            <input type="text" class="form-control" name="usuario" required>
                        </div>

                        <input class="btn shadow-2 col-md-12 text-uppercase mt-4" type="submit" name="accion" value="Ingresar">
                    </form>
                    
                    <hr>
                    
                    <div class="mt-1">
                        <div class="row">
                            <p style="display: inline; margin: 0;">¿Ya tienes una cuenta?</p>
                            <a href="login.html" class="registro-link"> Inicia Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
</body>
</html>