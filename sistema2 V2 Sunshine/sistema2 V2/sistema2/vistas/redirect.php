<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["id"])) {
    header('Location: index.php');
    exit;
}

if ($_SESSION["rol"] == 'admin') {
    header('Location: home.php'); // Cambia "admin_home.php" a la página de inicio del administrador
    exit;
} else if ($_SESSION["rol"] == 'usuario') {
    header('Location: home.php'); // Cambia "user_home.php" a la página de inicio del usuario
    exit;
} else {
    header('Location: index.php'); //se sierra sola
    exit;
}
?>
