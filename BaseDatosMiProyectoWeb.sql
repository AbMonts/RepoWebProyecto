select * from usuario;
select * from tareas;

SELECT id, nombre, apellido1, apellido2, rol 
FROM usuario 
WHERE correo = 'Anna@gmail.com' 
AND contrasena = '1234';

UPDATE usuario
SET rol = 'admin'
WHERE id = 1;


SELECT id, nombre, usario, correo, apellido1, apellido2, rol, contrasena 
                FROM usuario;
drop table Tareas;
CREATE TABLE Tareas (
    idTarea SERIAL PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fechaInicio TIMESTAMP,
    fechaFin TIMESTAMP UNIQUE NOT NULL,
    contenido TEXT NOT NULL,
	usuarioId INTEGER NOT NULL,
	FOREIGN KEY (usuarioId) REFERENCES usuario(id)
  	ON DELETE CASCADE
   	ON UPDATE CASCADE
);


CREATE TABLE Proyectos (
    idProyecto SERIAL PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fechaInicio TIMESTAMP,
    fechaFin TIMESTAMP UNIQUE NOT NULL,
    contenido TEXT NOT NULL,
	usuarioId INTEGER NOT NULL,
	FOREIGN KEY (usuarioId) REFERENCES usuario(id)
  	ON DELETE CASCADE
   	ON UPDATE CASCADE
);


CREATE TABLE Eventos (
    idEvento SERIAL PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    fechaInicio TIMESTAMP,
    fechaFin TIMESTAMP UNIQUE NOT NULL,
	usuarioId INTEGER NOT NULL,
	FOREIGN KEY (usuarioId) REFERENCES usuario(id)
  	ON DELETE CASCADE
   	ON UPDATE CASCADE
);


CREATE TABLE Notas (
    idNota SERIAL PRIMARY KEY,
    titulo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    contenido TEXT NOT NULL,
	usuarioId INTEGER NOT NULL,
	FOREIGN KEY (usuarioId) REFERENCES usuario(id)
  	ON DELETE CASCADE
   	ON UPDATE CASCADE
);

-- CREATE TABLE Tareas (
  ----  idTarea SERIAL PRIMARY KEY,
    --titulo VARCHAR(50) NOT NULL,
   -- descripcion TEXT NOT NULL,
  --  fechaInicio TIMESTAMP,
  --  fechaFin TIMESTAMP UNIQUE NOT NULL,
  --  contenido TEXT NOT NULL,
  --  usuarioId INTEGER NOT NULL,
   -- FOREIGN KEY (usuarioId) REFERENCES Usuarios(idUsuario)
  -- ON DELETE CASCADE
   --     ON UPDATE CASCADE
-- );


INSERT INTO usuario (nombre, apellido1, apellido2, correo, contrasena, rol)
VALUES
('Juanito', 'Banana', 'Perez', 'juanito@bananamail.com', '1234', 'admin'),
('Pepito', 'Grillo', 'Sanchez', 'pepito@grillomail.com', '1234', 'user'),
('Anita', 'Cerecita', 'Lopez', 'anita@cerecitamail.com', '1234', 'user'),
('Carlitos', 'Peperoni', 'Diaz', 'carlitos@peperonimail.com', '1234', 'user'),
('Lupita', 'Mango', 'Martinez', 'lupita@mangomail.com', '1234', 'admin'),
('Pancho', 'Pistacho', 'Gomez', 'pancho@pistachomail.com', '1234', 'user'),
('Toñito', 'Avocado', 'Fernandez', 'tonito@avocadomail.com', '1234', 'user'),
('Chuchito', 'Taco', 'Vasquez', 'chuchito@tacomail.com', '1234', 'admin'),
('Rosita', 'Cebollita', 'Garcia', 'rosita@cebollitamail.com', '1234', 'user'),
('Felipito', 'Chorizo', 'Rodriguez', 'felipito@chorizomail.com', '1234', 'user');


INSERT INTO Tareas (titulo, descripcion, fechaInicio, fechaFin, contenido, usuarioId)
VALUES
('Lavar Platillos Voladores', 'Limpieza de ovnis en el garaje', '2024-05-24 08:00:00', '2024-05-24 10:00:00', 'Usar jabón espacial', 1),
('Organizar Fiesta de Alienígenas', 'Preparar bocadillos para nuestros amigos del espacio', '2024-05-25 18:00:00', '2024-05-25 23:00:00', 'No olvidar los discos voladores', 2),
('Escribir Carta a Santa Claus', 'Pedir una nave espacial para Navidad', '2024-05-26 09:00:00', '2024-05-26 09:30:00', 'Ser muy específico con los detalles', 3),
('Pasear al Dragón', 'Sacar al dragón a dar una vuelta por el barrio', '2024-05-27 17:00:00', '2024-05-27 18:00:00', 'Llevar suficientes ovejas para el paseo', 4),
('Reparar Máquina del Tiempo', 'Arreglar la máquina antes de la próxima aventura', '2024-05-28 14:00:00', '2024-05-28 16:00:00', 'Verificar los cables de plutonio', 5),
('Plantación de Frijoles Mágicos', 'Cultivar frijoles para la próxima escalada al cielo', '2024-05-29 06:00:00', '2024-05-29 08:00:00', 'Regar con agua mágica', 6),
('Domar Unicornios', 'Entrenar unicornios para la competencia anual', '2024-05-30 10:00:00', '2024-05-30 12:00:00', 'Tener suficientes zanahorias', 7),
('Construir Castillo de Arena en Marte', 'Proyecto de arquitectura interplanetaria', '2024-05-31 13:00:00', '2024-05-31 17:00:00', 'Traer arena especial de Marte', 8),
('Organizar Concurso de Abducción', 'Competencia para ver quién abduce más rápido', '2024-06-01 15:00:00', '2024-06-01 18:00:00', 'Tener lista la nave nodriza', 9),
('Cazar Monstruo del Lago Ness', 'Expedición para encontrar a Nessie', '2024-06-02 05:00:00', '2024-06-02 22:00:00', 'Llevar cámaras de alta definición', 10);

INSERT INTO Proyectos (titulo, descripcion, fechaInicio, fechaFin, contenido, usuarioId)
VALUES
('Construir Rascacielos de Galletas', 'Proyecto de ingeniería comestible', '2024-05-24 08:00:00', '2024-06-24 10:00:00', 'Usar galletas reforzadas con chocolate', 1),
('Desarrollar Aplicación para Unicornio', 'App para localizar unicornios en el vecindario', '2024-05-25 08:00:00', '2024-07-25 10:00:00', 'Incluir rastreo GPS', 2),
('Investigación sobre Dragones Voladores', 'Estudio del comportamiento de dragones en vuelo', '2024-05-26 08:00:00', '2024-08-26 10:00:00', 'Documentar patrones de vuelo', 3),
('Cultivar Árbol de Helado', 'Probar diferentes sabores de helado en el árbol', '2024-05-27 08:00:00', '2024-09-27 10:00:00', 'Regar con leche y chocolate', 4),
('Inventar Teletransportador de Pizza', 'Sistema para enviar pizzas al instante', '2024-05-28 08:00:00', '2024-10-28 10:00:00', 'Probar con diferentes tipos de queso', 5),
('Organizar Olimpiadas de Ninjas', 'Competencia internacional de habilidades ninja', '2024-05-29 08:00:00', '2024-11-29 10:00:00', 'Crear obstáculos desafiantes', 6),
('Diseñar Cohete de Cartón', 'Construir un cohete completamente de cartón', '2024-05-30 08:00:00', '2024-12-30 10:00:00', 'Asegurarse de que sea resistente', 7),
('Exploración Submarina de Marte', 'Misiones para encontrar agua en Marte', '2024-05-31 08:00:00', '2025-01-31 10:00:00', 'Equipar el submarino con sensores avanzados', 8),
('Taller de Robots Cocineros', 'Desarrollar robots que cocinen platillos gourmet', '2024-06-01 08:00:00', '2025-02-01 10:00:00', 'Programar recetas de alta cocina', 9),
('Crear Parque de Diversiones en la Luna', 'Proyecto para construir el primer parque lunar', '2024-06-02 08:00:00', '2025-03-02 10:00:00', 'Diseñar atracciones con baja gravedad', 10);


INSERT INTO Eventos (titulo, descripcion, fechaInicio, fechaFin, usuarioId)
VALUES
('Festival de las Rosas Explosivas', 'Evento anual con fuegos artificiales florales', '2024-05-24 19:00:00', '2024-05-24 23:00:00', 1),
('Concierto de la Banda de Gnomos', 'Presentación musical de los mejores gnomos', '2024-05-25 19:00:00', '2024-05-25 23:00:00', 2),
('Competencia de Saltos sobre el Arcoíris', 'Salto de longitud con aterrizaje en arcoíris', '2024-05-26 19:00:00', '2024-05-26 23:00:00', 3),
('Desfile de Disfraces de Superhéroes', 'Desfile con los disfraces más creativos', '2024-05-27 19:00:00', '2024-05-27 23:00:00', 4),
('Feria de Comida de Otro Planeta', 'Degustación de platillos intergalácticos', '2024-05-28 19:00:00', '2024-05-28 23:00:00', 5),
('Carrera de Caracoles Gigantes', 'Competencia de velocidad entre caracoles gigantes', '2024-05-29 19:00:00', '2024-05-29 23:00:00', 6),
('Exposición de Pinturas Invisibles', 'Galería de arte con obras invisibles', '2024-05-30 19:00:00', '2024-05-30 23:00:00', 7),
('Bailar con los Monstruos del Lago', 'Fiesta de baile con los monstruos del lago', '2024-05-31 19:00:00', '2024-05-31 23:00:00', 8),
('Competencia de Risas', 'Concurso para ver quién ríe más fuerte', '2024-06-01 19:00:00', '2024-06-01 23:00:00', 9),
('Festival de las Sombras Mágicas', 'Evento nocturno con sombras mágicas', '2024-06-02 19:00:00', '2024-06-02 23:00:00', 10);


INSERT INTO Notas (titulo, descripcion, contenido, usuarioId)
VALUES
('Nota sobre el Puerquito Volador', 'Descripción de avistamientos de puerquitos voladores', 'Se ha visto en varios lugares del mundo', 1),
('Receta Secreta de la Galleta Gigante', 'Cómo hacer la galleta más grande del mundo', 'Ingredientes y pasos detallados', 2),
('Manual del Superhéroe Casero', 'Guía para crear tu propio traje de superhéroe', 'Materiales y técnicas avanzadas', 3),
('Guía de Jardinería Mágica', 'Cómo cultivar plantas mágicas en casa', 'Usar fertilizante encantado', 4),
('Proyecto de Teletransportación Casera', 'Construir un dispositivo de teletransportación', 'Instrucciones paso a paso', 5),
('Diario de Aventuras en el Tiempo', 'Relatos de viajes en la máquina del tiempo', 'Historias y experiencias', 6),
('Cómo Domar a un Dragón', 'Métodos efectivos para domar dragones', 'Técnicas y consejos útiles', 7),
('Manual de Construcción de Cohetes', 'Construcción de cohetes espaciales con materiales caseros', 'Planos y diagramas', 8),
('Recetario de Platos Intergalácticos', 'Cocina de otros planetas', 'Recetas detalladas', 9),
('Guía para Detectar Fantasmas', 'Métodos para detectar y capturar fantasmas', 'Herramientas y técnicas', 10);


SELECT  idTarea, titulo, descripcion, contenido, fechaInicio, fechaFin 
	FROM Tareas WHERE usuarioId = 1;

select * from usuario where id = 4;


SELECT * FROM Tareas WHERE usuarioId = 1;

SELECT id,nombre,apellido1,apellido2, correo,rol FROM usuario;

select*from usuario;