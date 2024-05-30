<header>
    <nav class="navbar navbar-expand-lg bg-pink navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ProTask</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">Funciones</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#">Nota: Una nota es un breve registro de información importante que quieres recordar.</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">Tarea: Una tarea es una actividad específica que debe completarse dentro de un período de tiempo determinado.</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">Recursos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Visual Studio</a></li>
                            <li><a class="dropdown-item" href="#">Bootstrap</a></li>
                            <li><a class="dropdown-item" href="#">XAMPP</a></li>
                            <li><a class="dropdown-item" href="#">pgAdmin</a></li>
                            <li><a class="dropdown-item" href="#">FlexBox</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">Conoce más</a>
                        <ul class="dropdown-menu">
                            <li> <!-- Poner el enlace del repositorio    -->
                                <a class="dropdown-item" href="https://github.com/tu-repo" target="_blank">Visita nuestro GitHub</a> 
                            </li>
                        </ul>
                    </li>

                </ul>
                <div class="barras col-5">
                    <form class="d-flex col-3" action="login.php">
                        <button class="btn btn-pink ms-auto" type="submit"><i class="fa-solid fa-circle-user"></i> Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
