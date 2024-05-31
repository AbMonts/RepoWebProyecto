<?php
session_start();
require("menuPrivado.php");

function calcularTiempoRestante($fechafin) {
    $fechaFin = new DateTime($fechafin);
    $fechaActual = new DateTime();
    $intervalo = $fechaActual->diff($fechaFin);
    $diasRestantes = $intervalo->days;

    // Calcular el porcentaje de tiempo restante (para la barra de progreso)
    $totalDias = (new DateTime($fechafin))->diff(new DateTime())->days;
    
    if ($totalDias == 0) {
        $porcentajeRestante = 10; // Si no hay días restantes, aseguramos que el porcentaje mínimo sea 10%
    } else {
        $porcentajeRestante = ($diasRestantes / $totalDias) * 90; // Máximo porcentaje 90%
        if ($porcentajeRestante < 10) {
            $porcentajeRestante = 10; // Porcentaje mínimo de 10%
        }
    }

    return [$diasRestantes, $porcentajeRestante];
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eventos del Mes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <style>
    .card-container {
      position: absolute;
      top: 70px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      justify-content: center;
      gap: 20px;
      color: #ecf0f1; 
    }
    .card {
      width: 18rem;
      transition: transform 0.3s ease-in-out;
    }
    .card:hover {
      transform: translateY(90px);
    }
    .toast-container {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      gap: 20px;
    }
    .toast-body {
      color: black;
    }
    .modal.fade .modal-dialog {
      transform: translate(0, -25%);
      transition: transform 0.3s ease-out;
    }
    .modal.fade.show .modal-dialog {
      transform: translate(0, 0);
    }
  </style>
</head>
<body>

<div class="container my-5"></div>
<main>
  <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="imgs/proyecto.jpeg" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="imgs/tareas.jpg" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
<div class="card-container">
    <a href="Notas.php" class="card">
        <img src="imgs/tareas2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Notas</h5>
            <p class="card-text">Puedes crear tus propias notas.</p>
        </div>
    </a>
    <a href="Tareas.php" class="card">
        <img src="imgs/tareas2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Tareas</h5>
            <p class="card-text">Haz un listado de tareas, y agéndalas.</p>
        </div>
    </a>
    <a href="Eventos.php" class="card">
        <img src="imgs/gestion.webp" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title">Eventos</h5>
            <p class="card-text">Agenda próximos eventos.</p>
        </div>
    </a>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
    <?php
    require_once("../datos/DAOEventos.php");
    $idUsuario = $_SESSION['id'];
    $daoEvento = new DAOEvento();
    $eventos = $daoEvento->obtenerEventosDelMes($idUsuario);

    ?>
    <div class="container mt-5 mx-5">
      <div class="card card-item" id="cardEvents">
        <div class="card-header">
          Eventos de este Mes
        </div>
        <div class="card-body toast-container py-5">
          <?php foreach ($eventos as $evento):
              list($diasRestantes, $porcentajeRestante) = calcularTiempoRestante($evento->fechafin);
          ?>
          <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="me-auto"><?php echo htmlspecialchars($evento->titulo); ?></strong>
              <small class="text-muted"><?php echo htmlspecialchars($evento->fechainicio); ?></small>
            </div>
            <div class="toast-body">
              <?php echo htmlspecialchars($evento->descripcion); ?>
              <div><strong>Fecha Fin:</strong> <?php echo htmlspecialchars($evento->fechafin); ?></div>
              <div class="progress mt-2">
                <div class="progress-bar" role="progressbar" style="width: <?php echo $porcentajeRestante; ?>%;" aria-valuenow="<?php echo $porcentajeRestante; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $porcentajeRestante; ?>%</div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-aoe/iQpD+qJJQljWkHD9E3qu9IqSwDoF7ub5i+4/0EGdtKYYeq7iLZPzVwW2wsUh" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QT3ZpjKwiIk1A7oTOQo4avczWYXtmfA2jGFuDA1jOBPpJ2VeQIYFE5ppQL0N6gCV" crossorigin="anonymous"></script>

</body>
</html>
