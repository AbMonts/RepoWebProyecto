<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Bootstrap demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
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
    }
  </style>
</head>
<body>
  <?php require("menuPrivado.php"); ?>
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
      <div class="card">
        <img src="imgs/tareas2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Notas</h5>
          <p class="card-text">Puedes crear tus propias notas.</p>
        </div>
      </div>
      <div class="card">
        <img src="imgs/tareas2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Tareas</h5>
          <p class="card-text">Haz un listado de tareas, y agendalas.</p>
        </div>
      </div>
      <div class="card">
        <img src="imgs/gestion.webp" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Eventos</h5>
          <p class="card-text">Agenda próximos eventos.</p>
        </div>
      </div>
    </div>

    <!-- Mostrar los eventos del usuario -->
    <?php
    // Asegúrate de incluir DAOEvento y de tener un objeto de sesión de usuario ya establecido
    require_once("../datos/DAOEventos.php");
    $idUsuario = $_SESSION['id']; // Asumiendo que el ID del usuario está almacenado en la sesión
    $daoEvento = new DAOEvento();
    $eventos = $daoEvento->obtenerPorId($idUsuario);
    ?>

    <div class="container mt-5">
      <div class="card">
        <div class="card-header">
          Eventos
        </div>
        <div class="card-body">
          <div class="accordion" id="accordionEventos">
            <?php foreach ($eventos as $evento): ?>
            <div class="accordion-item">
              <h2 class="accordion-header" id="heading<?php echo $evento->id; ?>">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $evento->id; ?>" aria-expanded="true" aria-controls="collapse<?php echo $evento->id; ?>">
                  <?php echo htmlspecialchars($evento->titulo); ?>
                </button>
              </h2>
              <div id="collapse<?php echo $evento->id; ?>" class="accordion-collapse collapse" aria-labelledby="heading<?php echo $evento->id; ?>" data-bs-parent="#accordionEventos">
                <div class="accordion-body">
                  <p><?php echo htmlspecialchars($evento->descripcion); ?></p>
                  <p><strong>Fecha Inicio:</strong> <?php echo htmlspecialchars($evento->fechaInicio); ?></p>
                  <p><strong>Fecha Fin:</strong> <?php echo htmlspecialchars($evento->fechaFin); ?></p>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarEvento<?php echo $evento->id; ?>">
                    Editar
                  </button>
                </div>
              </div>
            </div>

            <!-- Modal para editar evento -->
            <div class="modal fade" id="modalEditarEvento<?php echo $evento->id; ?>" tabindex="-1" aria-labelledby="modalEditarEventoLabel<?php echo $evento->id; ?>" aria-hidden="true">
              <div class="modal-dialog">
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
                        <input type="datetime-local" class="form-control" id="fechaInicio" name="fechaInicio" value="<?php echo htmlspecialchars($evento->fechaInicio); ?>">
                      </div>
                      <div class="mb-3">
                        <label for="fechaFin" class="form-label">Fecha Fin</label>
                        <input type="datetime-local" class="form-control" id="fechaFin" name="fechaFin" value="<?php echo htmlspecialchars($evento->fechaFin); ?>">
                      </div>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php require("pie.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
