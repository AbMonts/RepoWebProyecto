<?php
// Iniciar la sesión si no está ya iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirigir a index.php si no se ha iniciado sesión
if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit;
}

$usuarioId = $_SESSION["id"];
$usuarioRol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;

// Obtener el nombre del archivo actual
$currentFile = basename($_SERVER['PHP_SELF']);

// // Depuración: Verifica los valores de la sesión
// // Esto debería comentarse o eliminarse en producción
// echo "Usuario ID: " . $usuarioId . "<br>";
// echo "Usuario Rol: " . $usuarioRol . "<br>";
// echo "Archivo Actual: " . $currentFile . "<br>";
?>

<header>
    <nav class="navbar navbar-expand-lg bg-pink navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ProTask</a> 
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Inicio</a>
                    </li>

                    <?php if ($currentFile != 'home.php' && $usuarioRol == 'admin') { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Seguimiento</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="listaUsuarios.php">Usuarios</a>
                                </li>
                                <!-- <li><a class="dropdown-item" href="#">Lo que puedes lograr</a></li> -->
                            </ul>
                        </li>
                    <?php } ?>


                    <?php if ($usuarioRol == 'usuario' && $currentFile != 'home.php' or $currentFile != 'Eventos.php') { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Actividades
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="Tareas.php">Tareas</a></li>
                            <li><a class="dropdown-item" href="Notas.php">Notas</a></li>
                            <li><a class="dropdown-item" href="Eventos.php">Eventos</a></li>
                        </ul>
                    </li>
                    <?php } ?>
                    
                    <li class="nav-item" style="display: none;">
                        <a class="nav-link" href="#">Perfil</a>
                    </li>
                </ul>
                <form class="d-flex col-4" action="cerrarSesion.php">
                    <button class="btn btn-light ms-auto" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
                </form>
            </div>
        </div>
    </nav>
</header>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
