<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Notas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="css/estilos.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js" integrity="sha512-Rfdu1c2/8/1hrbiSFT8+P+57odUXcFGmTfJmvjVOhdQgi1+xW6BfW8I/TPZMb/gAjTxXZ8ykA69hYbfPoc3PA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link  href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require("menuPrivado.php"); ?>

<div class="container pt-4">
  <h2>Notas</h2>
  
  <!-- Botón para abrir el modal -->
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarNotaModal">
    Agregar Nota
  </button>

  <div id="notasContainer" class="row">
    <?php
      require_once '../datos/DAONotas.php';

      $daoNotas = new DAONotas();
      $idUsuario = 1; // Reemplaza esto con el ID del usuario que esté autenticado en tu aplicación
      $notas = $daoNotas->obtenerNotasPorUsuario($idUsuario);

      if ($notas) {
        foreach ($notas as $nota) {
          echo "
          <div class='col-12 col-md-6 mb-3'>
            <div class='card h-100'>
              <div class='card-header'>
                <h5 class='mb-0'>
                  " . htmlspecialchars($nota->titulo) . "
                </h5>
              </div>
              <div class='card-body'>
                <div class='accordion' id='accordionNota{$nota->id}'>
                  <div class='accordion-item'>
                    <h2 class='accordion-header' id='headingNota{$nota->id}'>
                      <button class='accordion-button' type='button' data-bs-toggle='collapse' data-bs-target='#collapseNota{$nota->id}' aria-expanded='false' aria-controls='collapseNota{$nota->id}'>
                        Ver contenido
                      </button>
                    </h2>
                    <div id='collapseNota{$nota->id}' class='accordion-collapse collapse' aria-labelledby='headingNota{$nota->id}' data-bs-parent='#accordionNota{$nota->id}'>
                      <div class='accordion-body'>
                        <p>" . htmlspecialchars($nota->contenido) . "</p>
                        <a href='descargarNota.php?id=" . $nota->id . "' class='btn btn-primary' download><i class='fas fa-download'></i> Descargar</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>";
        }
      } else {
        echo "<div class='alert alert-warning'>No hay notas disponibles</div>";
      }
    ?>
  </div>
</div>

<!-- Modal para agregar nota -->
<div class="modal fade" id="agregarNotaModal" tabindex="-1" aria-labelledby="agregarNotaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarNotaModalLabel">Agregar Nota</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formAgregarNota" method="post" action="agregarNota.php">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
          </div>
          <div class="mb-3">
            <label for="contenido" class="form-label">Contenido</label>
            <textarea class="form-control" id="contenido" name="contenido" rows="3" required></textarea>
          </div>
          <input type="hidden" name="idUsuario" value="<?php echo $idUsuario; ?>">
          <button type="submit" class="btn btn-primary">Guardar Nota</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', (event) => {
    new Sortable(document.getElementById('notasContainer'), {
      animation: 150,
      ghostClass: 'bg-light'
    });
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>

</body>
</html>
