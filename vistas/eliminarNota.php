<?php
require_once '../datos/DAONotas.php';

// Verificar si se recibieron datos y si el campo 'id' está presente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Obtener y limpiar el ID de la nota
    $idNota = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    
    // Validar que el ID sea un entero válido
    if ($idNota === false || $idNota <= 0) {
        echo json_encode(['error' => 'ID de nota inválido']);
        exit();
    }

    // Crear una instancia del DAO de Notas
    $daoNotas = new DAONotas();

    // Verificar si la nota existe antes de intentar eliminarla (opcional)

    // Intentar eliminar la nota
    $result = $daoNotas->eliminarNota($idNota);

    // Devolver el resultado como JSON
    echo json_encode(['success' => $result]);
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>
