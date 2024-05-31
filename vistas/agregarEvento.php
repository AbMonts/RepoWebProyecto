<?php
require_once '../datos/DAOEventos.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fechainicio = $_POST['fechainicio'];
    $fechafin = $_POST['fechafin'];
    $idUsuario = $_POST['idusuario'];

    $daoEventos = new DAOEventos();

    if ($daoEventos->agregar($titulo, $descripcion, $fechainicio, $fechafin, $idUsuario)) {
        // Redirige al usuario a la página principal de eventos
        header('Location: eventos.php');
        exit();
    } else {
        echo "Error al agregar el evento.";
    }
}
?>
