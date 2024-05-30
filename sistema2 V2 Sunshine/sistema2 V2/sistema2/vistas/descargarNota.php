<?php
// Verificar si se proporcionó un ID de nota válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireccionar o mostrar un mensaje de error
    header("Location: index.php");
    exit;
}

require_once '../datos/DAONotas.php'; // Reemplaza 'DAONotas.php' con el archivo que contiene tu DAO de notas

// Obtener el ID de la nota desde la URL
$idNota = $_GET['id'];

// Crear una instancia del DAO de notas
$daoNotas = new DAONotas();

// Obtener la nota por su ID
$nota = $daoNotas->obtenerNotaPorId($idNota);

// Verificar si se encontró la nota
if (!$nota) {
    // Redireccionar o mostrar un mensaje de error si la nota no existe
    header("Location: index.php");
    exit;
}

// Configurar las cabeceras para descargar el archivo
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"" . $nota->titulo . ".txt\"");

// Generar el contenido del archivo de texto
$contenidoArchivo = "Título: " . $nota->titulo . "\n\n";
$contenidoArchivo .= "Contenido: " . $nota->contenido;

// Imprimir el contenido del archivo para que se descargue como un archivo
echo $contenidoArchivo;
