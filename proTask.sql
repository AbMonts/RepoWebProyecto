-- Crear tabla de usuarios
CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido1 VARCHAR(100) NOT NULL,
    apellido2 VARCHAR(100),
    correo VARCHAR(100) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    rol VARCHAR(50) CHECK (rol IN ('usuario', 'admin')),
    isEnabled BOOLEAN DEFAULT TRUE
);

ALTER TABLE usuarios 
ADD COLUMN usuario VARCHAR(100) UNIQUE;

-- Crear tabla de tareas
CREATE TABLE tareas (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT,
    idUsuario INTEGER NOT NULL,
    fechaFin TIMESTAMP,
    fechaInicio TIMESTAMP NOT NULL,
    isDone BOOLEAN DEFAULT FALSE,
    compartidoCon INTEGER[],
    CONSTRAINT fk_usuario
      FOREIGN KEY(idUsuario) 
	  REFERENCES usuarios(id)
);

-- Crear tabla de notas
CREATE TABLE notas (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    contenido TEXT,
    idUsuario INTEGER NOT NULL,
    CONSTRAINT fk_usuario
      FOREIGN KEY(idUsuario) 
	  REFERENCES usuarios(id)
);

-- Crear tabla de eventos
CREATE TABLE eventos (
    id SERIAL PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fechaInicio TIMESTAMP NOT NULL,
    fechaFin TIMESTAMP,
    idUsuario INTEGER NOT NULL,
    CONSTRAINT fk_usuario
      FOREIGN KEY(idUsuario) 
	  REFERENCES usuarios(id)
);

-- Inserción de usuarios
INSERT INTO usuarios (nombre, apellido1, apellido2, correo, contrasena, rol, isEnabled) VALUES
('Juan', 'Pérez', 'Gómez', 'juan.perez@example.com', 'password1', 'usuario', TRUE),
('María', 'López', 'Martínez', 'maria.lopez@example.com', 'password2', 'usuario', TRUE),
('Carlos', 'Sánchez', 'Rodríguez', 'carlos.sanchez@example.com', 'password3', 'usuario', TRUE),
('Ana', 'García', 'Hernández', 'ana.garcia@example.com', 'password4', 'usuario', TRUE),
('Admin', 'Admin', 'Admin', 'admin@example.com', 'adminpassword', 'admin', TRUE);

-- Supongamos que los IDs de los usuarios son 1, 2, 3, 4 y 5 respectivamente

-- Inserción de tareas para cada usuario
INSERT INTO tareas (titulo, contenido, idUsuario, fechaFin, fechaInicio, isDone, compartidoCon) VALUES
('Tarea 1 de Juan', 'Contenido de la tarea 1 de Juan', 1, '2024-06-01 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 2 de Juan', 'Contenido de la tarea 2 de Juan', 1, '2024-06-02 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 3 de Juan', 'Contenido de la tarea 3 de Juan', 1, '2024-06-03 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 4 de Juan', 'Contenido de la tarea 4 de Juan', 1, '2024-06-04 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),

('Tarea 1 de María', 'Contenido de la tarea 1 de María', 2, '2024-06-01 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 2 de María', 'Contenido de la tarea 2 de María', 2, '2024-06-02 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 3 de María', 'Contenido de la tarea 3 de María', 2, '2024-06-03 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 4 de María', 'Contenido de la tarea 4 de María', 2, '2024-06-04 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),

('Tarea 1 de Carlos', 'Contenido de la tarea 1 de Carlos', 3, '2024-06-01 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 2 de Carlos', 'Contenido de la tarea 2 de Carlos', 3, '2024-06-02 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 3 de Carlos', 'Contenido de la tarea 3 de Carlos', 3, '2024-06-03 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 4 de Carlos', 'Contenido de la tarea 4 de Carlos', 3, '2024-06-04 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),

('Tarea 1 de Ana', 'Contenido de la tarea 1 de Ana', 4, '2024-06-01 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 2 de Ana', 'Contenido de la tarea 2 de Ana', 4, '2024-06-02 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 3 de Ana', 'Contenido de la tarea 3 de Ana', 4, '2024-06-03 12:00:00', '2024-05-28 12:00:00', FALSE, '{}'),
('Tarea 4 de Ana', 'Contenido de la tarea 4 de Ana', 4, '2024-06-04 12:00:00', '2024-05-28 12:00:00', FALSE, '{}');

-- Inserción de notas para cada usuario
INSERT INTO notas (titulo, contenido, idUsuario) VALUES
('Nota 1 de Juan', 'Contenido de la nota 1 de Juan', 1),
('Nota 2 de Juan', 'Contenido de la nota 2 de Juan', 1),
('Nota 3 de Juan', 'Contenido de la nota 3 de Juan', 1),
('Nota 4 de Juan', 'Contenido de la nota 4 de Juan', 1),

('Nota 1 de María', 'Contenido de la nota 1 de María', 2),
('Nota 2 de María', 'Contenido de la nota 2 de María', 2),
('Nota 3 de María', 'Contenido de la nota 3 de María', 2),
('Nota 4 de María', 'Contenido de la nota 4 de María', 2),

('Nota 1 de Carlos', 'Contenido de la nota 1 de Carlos', 3),
('Nota 2 de Carlos', 'Contenido de la nota 2 de Carlos', 3),
('Nota 3 de Carlos', 'Contenido de la nota 3 de Carlos', 3),
('Nota 4 de Carlos', 'Contenido de la nota 4 de Carlos', 3),

('Nota 1 de Ana', 'Contenido de la nota 1 de Ana', 4),
('Nota 2 de Ana', 'Contenido de la nota 2 de Ana', 4),
('Nota 3 de Ana', 'Contenido de la nota 3 de Ana', 4),
('Nota 4 de Ana', 'Contenido de la nota 4 de Ana', 4);

select * from usuarios;
SELECT id, nombre, apellido1, apellido2, rol, contrasena 
                FROM usuarios WHERE correo = 'juan.perez@example.com';
select * from eventos;

SELECT id, titulo, contenido, fechainicio, fechafin, isdone FROM Tareas WHERE idUsuario = 1;

SELECT id, nombre, correo, apellido1, apellido2, rol, contrasena FROM usuarios WHERE id=1;

UPDATE usuarios
  SET nombre = 'Juanito', correo = 'juan.perez@example.com', apellido1 = 'Garcia', apellido2 = 'Ramos', rol = 'usuario', contrasena = '1234', isenabled = true
                    WHERE id = 1;


INSERT INTO usuarios (nombre, apellido1, apellido2, correo, usuario, rol, contrasena, isEnabled) 
                VALUES ('Abril', 'Penaloza', 'Tenorio', 'abrilmontse15@gmail.com', 'AbMonts', 'usuario', 1234, true);


SELECT * FROM eventos WHERE idUsuario = 1;

SELECT id, titulo, descripcion, fechaInicio, fechaFin
                    FROM eventos
                    WHERE idUsuario = 1;