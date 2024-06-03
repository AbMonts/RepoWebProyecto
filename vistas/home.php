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
  <link  href="css/bootstrap.min.css" rel="stylesheet">
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
  <?php elseif (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
    <div class="card-container">
        <a href="listaUsuarios.php" class="card">
            <img src="imgs/gestion.webp" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Gestionar usuarios</h5>
                <p class="card-text">Administra los usuarios del sistema.</p>
            </div>
        </a>
    </div>
  <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-aoe/iQpD+qJJQljWkHD9E3qu9IqSwDoF7ub5i+4/0EGdtKYYeq7iLZPzVwW2wsUh" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-QT3ZpjKwiIk1A7oTOQo4avczWYXtmfA2jGFuDA1jOBPpJ2VeQIYFE5ppQL0N6gCV" crossorigin="anonymous"></script>
<script src="js/login.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
