<?php
require_once '../datos/DAONotas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $idUsuario = $_POST['idUsuario'];

    $daoNotas = new DAONotas();
    $nota = new Nota();
    $nota->titulo = $titulo;
    $nota->contenido = $contenido;
    $nota->idUsuario = $idUsuario;

    if ($daoNotas->agregarNota($nota)) {
        // Redirige al usuario a la página principal de notas
        header('Location: notas.php');
        exit();
    } else {
        echo "Error al agregar la nota.";
    }
}
?>
