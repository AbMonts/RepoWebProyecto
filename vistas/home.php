<?php
session_start();
require("menuPrivado.php");
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
        <p class="card-text">Haz un listado de tareas, y agendalas.</p>
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

  <center>
    <div class="container my-5"></div>
    <main id="carrusel_tareas">
      <div class="container">
        <div id="carouselExampleAutoplaying" class="carousel slide mb-5" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="imgs/Evento2.jpg" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Leyenda de la primera imagen</h5>
                <p>Descripción o cualquier otro texto que desees agregar.</p>
              </div>
            </div>
            <div class="carousel-item">
              <img src="imgs/Evento2.jpg" class="d-block w-100" alt="...">
              <div class="carousel-caption d-none d-md-block">
                <h5>Leyenda de la segunda imagen</h5>
                <p>Descripción o cualquier otro texto que desees agregar.</p>
              </div>
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
      </div>
    </main>
  </center>

  <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?>
    <?php
    require_once("../datos/DAOEventos.php");
    $idUsuario = $_SESSION['id'];
    $daoEvento = new DAOEvento();
    $eventos = $daoEvento->obtenerEventosDelMes($idUsuario);
    ?>
    <div class="container mt-5">
      <div class="card card-item" id="cardEvents">
        <div class="card-header">
          Eventos de este Mes
        </div>
        <div class="card-body toast-container py-5">
          <?php foreach ($eventos as $evento): ?>
          <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
              <strong class="me-auto"><?php echo htmlspecialchars($evento->titulo); ?></strong>
              <small class="text-muted"><?php echo htmlspecialchars($evento->fechainicio); ?></small>
              <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
              <?php echo htmlspecialchars($evento->descripcion); ?>
              <div><strong>Fecha Fin:</strong> <?php echo htmlspecialchars($evento->fechafin); ?></div>
              <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalEditarEvento<?php echo $evento->id; ?>" data-backdrop="static" data-keyboard="false">
                Editar
              </button>
            </div>
          </div>

          <div class="modal fade" id="modalEditarEvento<?php echo $evento->id; ?>" tabindex="-1" aria-labelledby="modalEditarEventoLabel<?php echo $evento->id; ?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="modalEditarEventoLabel<?php echo $evento->id; ?>">Editar Evento</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="actualizar_evento.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $evento->id; ?>">
                    <div class="mb-3">
                      <label for="titulo" class="form-label">Título</label>
                      <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($evento->titulo); ?>">
                    </div>
                    <div class="mb-3">
                      <label for="descripcion" class="form-label">Descripción</label>
                      <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($evento->descripcion); ?></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="fechaInicio" class="form-label">Fecha Inicio</label>
                      <input type="datetime-local" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($evento->fechainicio); ?>">
                    </div>
                    <div class="mb-3">
                      <label for="fechaFin" class="form-label">Fecha Fin</label>
                      <input type="datetime-local" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($evento->fechafin); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                  </form>
                </div>
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
<script>
  // Desplazarse hacia arriba cuando se abra el modal
  var modals = document.querySelectorAll('.modal');
  modals.forEach(function(modal) {
    modal.addEventListener('shown.bs.modal', function () {
      window.scrollTo(0, 0);
    });
  });
</script>
</body>
</html>
