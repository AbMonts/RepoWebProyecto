<?php
require_once '../datos/DAONotas.php';
require_once '../modelos/Notas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $idUsuario = $_POST['idUsuario'];


    // Verificar si se ha cargado un archivo
    if (isset($_FILES['archivoNota']) && $_FILES['archivoNota']['error'] == UPLOAD_ERR_OK) {
        $archivoTmpPath = $_FILES['archivoNota']['tmp_name'];
        $archivoContenido = file_get_contents($archivoTmpPath);
        var_dump("Contiene: ".$archivoContenido);
        // Si el contenido del archivo no está vacío, usa el contenido del archivo
        if (!empty($archivoContenido)) {
            $contenido = $archivoContenido;
        }
    }

    $daoNotas = new DAONotas();
    $nota = new Notas();
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
