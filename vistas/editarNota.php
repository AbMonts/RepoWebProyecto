<?php
require_once '../datos/DAONotas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación de existencia de datos
    if (!isset($_POST['id']) || !isset($_POST['titulo']) || !isset($_POST['contenido'])) {
        header('Location: notas.php?mensaje=error');
        exit();
    }

    // Obtener datos de la solicitud POST y limpiarlos
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
    $contenido = filter_input(INPUT_POST, 'contenido', FILTER_SANITIZE_STRING);

    // Validación de tipo de datos
    if ($id === false || $titulo === null || $contenido === null) {
        header('Location: notas.php?mensaje=error');
        exit();
    }

    // Validación de longitud de datos
    if (strlen($titulo) > 255 || strlen($contenido) > 1000) {
        header('Location: notas.php?mensaje=error');
        exit();
    }

    // Crear instancia del DAO de Notas
    $daoNotas = new DAONotas();

    // Verificar si el usuario tiene permisos para modificar la nota (seguridad de sesión) - Requiere implementación

    // Validación de campos específicos (en este caso, validación del ID)
    if ($id <= 0) {
        header('Location: notas.php?mensaje=error');
        exit();
    }

    // Modificar la nota
    $resultado = $daoNotas->modificarNota($id, $titulo, $contenido);

    if ($resultado) {
        header('Location: notas.php?mensaje=nota_editada');
    } else {
        header('Location: notas.php?mensaje=error');
    }
}
?>
