<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit;
}
$usuarioId = $_SESSION["id"];
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
                        <a class="nav-link active" aria-current="page" href="redirect.php">Inicio</a> <!-- Modificado aquí -->
                    </li>
                    <li class="nav-item dropdown">
                        
                        <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">  <!--aqui sera otra pagina que segun el rol demuestra el progreso  <i class="fa-solid fa-thumbtack"></i>-->
                            Seguimiento
                        </a>
                        <ul class="dropdown-menu dropdown-toggle">
                            <?php if ($_SESSION["rol"] == 'admin') { ?>
                                <li><a class="dropdown-item" href="listaUsuarios.php">Usuarios</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="#">Productos</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            Actividades
                        </a>
                        <ul class="dropdown-menu">
                            <?php if ($_SESSION["rol"] == 'usuario') { ?>
                                <li><a class="dropdown-item" href="Tareas.php">Tareas</a></li>
                                <li><a class="dropdown-item" href="Notas.php">Notas</a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class="nav-item">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>