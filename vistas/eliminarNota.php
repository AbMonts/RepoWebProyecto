<?php
require_once '../datos/DAONotas.php';

$data = json_decode(file_get_contents('php://input'), true);
$idNota = $data['id'];

$daoNotas = new DAONotas();
$result = $daoNotas->eliminarNota($idNota);

echo json_encode(['success' => $result]);
?>
