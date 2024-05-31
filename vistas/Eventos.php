<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos del Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Eventos del Usuario</h1>
    <div class="list-group">
        <!-- Aquí iteramos sobre los eventos del usuario -->
        <?php
        // Suponiendo que $eventos contiene los datos de los eventos del usuario
        foreach ($eventos as $evento) {
            echo '<a href="#" class="list-group-item list-group-item-action" data-toggle="offcanvas" data-target="#offcanvas' . $evento->id . '">' . $evento->nombre . '</a>';
        }
        ?>
    </div>
</div>

<!-- Aquí generamos los offcanvas para cada evento -->
<?php
foreach ($eventos as $evento) {
    echo '
    <div class="offcanvas offcanvas-right" id="offcanvas' . $evento->id . '" tabindex="-1" role="dialog" aria-labelledby="offcanvasLabel' . $evento->id . '">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasLabel' . $evento->id . '">' . $evento->nombre . '</h5>
            <button type="button" class="close" data-dismiss="offcanvas" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="offcanvas-body">
            <p>' . $evento->descripcion . '</p>
            <p><strong>Fecha:</strong> ' . $evento->fecha . '</p>
            <p><strong>Ubicación:</strong> ' . $evento->ubicacion . '</p>
        </div>
    </div>';
}
?>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
