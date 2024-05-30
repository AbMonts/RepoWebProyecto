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
            <p class="card-text">Agenda proximos eventos.</p>
           
          </div>
        </div>
      </div>


      <!-- poner condicion para que se muestre solo cuando se logea un usuario con el rol=usuario -->
        <div class="targetasInfo my-4">
            <div class="card item">
                <div class="card-header">
                    --------- Eventos ----------
                </div>
                <div class="card-body">
                    
                </div>
            </div>
        </div>


  </main>
  <?php require("pie.php"); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"
    integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>