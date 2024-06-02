<?php
require_once '../datos/DAONotas.php';
require_once '../modelos/Notas.php';

// Verificar si la solicitud es POST y si los campos requeridos están presentes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['titulo']) && isset($_POST['contenido']) && isset($_POST['idUsuario'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $idUsuario = $_POST['idUsuario'];

    $mensaje = '';
    $tipo = '';

    // Sanitizar los datos
    $titulo = filter_var($titulo, FILTER_SANITIZE_STRING);
    $contenido = filter_var($contenido, FILTER_SANITIZE_STRING);
    $idUsuario = filter_var($idUsuario, FILTER_SANITIZE_NUMBER_INT);

    // Validar la longitud del título y el contenido
    if (strlen($titulo) > 255) {
        echo "Error: El título no puede tener más de 255 caracteres.";
        exit();
    }

    if (strlen($contenido) > 1000) {
        echo "Error: El contenido no puede tener más de 1000 caracteres.";
        exit();
    }

    // Validar si se ha cargado el archivo de texto y su tipo
    if (isset($_FILES['archivoNota']) && $_FILES['archivoNota']['error'] == UPLOAD_ERR_OK) {
        $archivoTmpPath = $_FILES['archivoNota']['tmp_name'];
        $archivoContenido = file_get_contents($archivoTmpPath);

        // Verificar el tipo del archivo
        $fileType = mime_content_type($archivoTmpPath);
        if ($fileType != 'text/plain') {
            echo "Error: Solo se permiten archivos de texto plano (.txt).";
            exit();
        }

        // Verificar el tamaño del archivo (máximo de 1MB)
        if ($_FILES['archivoNota']['size'] > 1000000) {
            echo "Error: El tamaño máximo permitido para el archivo es de 1MB.";
            exit();
        }

        // Procesar y limpiar el contenido del archivo
        $contenido = filter_var($archivoContenido, FILTER_SANITIZE_STRING);
    }

    // Crear una instancia del DAO de Notas y del modelo de Notas
    $daoNotas = new DAONotas();
    $nota = new Notas();
    $nota->titulo = $titulo;
    $nota->contenido = $contenido;
    $nota->idUsuario = $idUsuario;

    // Intentar agregar la nota
    if ($daoNotas->agregarNota($nota)) {
        $mensaje = 'Nota agregada con exito :D';
        $tipo = 'success';
    } else {
        $mensaje = 'Error al agregar la nota :(';
        $tipo = 'error';
    }


    $_SESSION['mensaje'] = $mensaje;
    $_SESSION['tipo'] = $tipo;
    
    header("Location: Notas.php");
    exit();
} 


?>
