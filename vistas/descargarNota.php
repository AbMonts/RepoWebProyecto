<?php
// Verificar si se proporciono un ID de nota vlido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireccionar o mostrar un mensaje de error
    header("Location: index.php");
    exit;
}

require_once '../datos/DAONotas.php'; 


$idNota = $_GET['id'];


$daoNotas = new DAONotas();


$nota = $daoNotas->obtenerNotaPorId($idNota);

if (!$nota) {
    header("Location: index.php");
    exit;
}


header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"" . $nota->titulo . ".txt\"");


$contenidoArchivo = "Título: " . $nota->titulo . "\n\n";
$contenidoArchivo .= "Contenido: " . $nota->contenido;

echo $contenidoArchivo;
