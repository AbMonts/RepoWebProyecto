<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// llevar a index.php si no se ha iniciado sesión
if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit;
}

$usuarioId = $_SESSION["id"];
$usuarioRol = isset($_SESSION["rol"]) ? $_SESSION["rol"] : null;

// Obtener el nombre del archivo actual
$currentFile = basename($_SERVER['PHP_SELF']);

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

                    <?php if ($usuarioRol == 'admin' && $currentFile != 'registroUsuarios.php') { ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-lg btn-primary" href="listaUsuarios.php" style="margin: 0 5px;">Seguimiento</a>
                        </li>
                    <?php } ?>

                    <?php if ($usuarioRol == 'usuario') { ?>
                        <?php if ($currentFile != 'Tareas.php') { ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-lg btn-primary" href="Tareas.php" style="margin: 0 5px;">Tareas</a>
                            </li>
                        <?php } ?>
                        <?php if ($currentFile != 'Notas.php') { ?>
                            <li class="nav-item">
                                <a class="nav-link btn btn-lg btn-primary" href="Notas.php" style="margin: 0 5px;">Notas</a>
                            </li>
                        <?php } ?>
                        <?php if ($currentFile != 'Eventos.php') { ?>
                            <li> class="nav-item">
                                <a class="nav-link btn btn-lg btn-primary" href="Eventos.php" style="margin: 0 5px;">Eventos</a>
                            </li>
                        <?php } ?>
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
<script src="js/bootstrap.bundle.min.js"></script>

<style>
    .nav-link.btn:hover {
        background-color: #36677D ; /* Cambia este color al que desees */
        color: #ffff;
    }
</style>
