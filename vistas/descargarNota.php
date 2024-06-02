<?php
// Verificar si se proporcionó un ID de nota válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireccionar con un mensaje de error si el ID de nota no es válido
    header("Location: index.php?error=invalid_id");
    exit;
}

require_once '../datos/DAONotas.php'; 

$idNota = $_GET['id'];

$daoNotas = new DAONotas();

// Obtener la nota por su ID
$nota = $daoNotas->obtenerNotaPorId($idNota);

// Verificar si la nota existe
if (!$nota) {
    // Redireccionar con un mensaje de error si la nota no existe
    header("Location: index.php?error=note_not_found");
    exit;
}

// Establecer el tipo de contenido y el nombre del archivo
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"" . $nota->titulo . ".txt\"");

// Construir el contenido del archivo
$contenidoArchivo = "Título: " . $nota->titulo . "\n\n";
$contenidoArchivo .= "Contenido: " . $nota->contenido;

// Imprimir el contenido del archivo
echo $contenidoArchivo;
?>
