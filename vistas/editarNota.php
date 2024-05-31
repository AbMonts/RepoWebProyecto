<?php
require_once '../datos/DAONotas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];

    $daoNotas = new DAONotas();
    $resultado = $daoNotas->modificarNota($id, $titulo, $contenido);

    if ($resultado) {
        header('Location: notas.php?mensaje=nota_editada');
    } else {
        header('Location: notas.php?mensaje=error');
    }
}
?>
