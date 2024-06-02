<?php
require_once 'Conexion.php'; 

class DAONotas {
    private $conexion; 

    private function conectar() {
        try {
            $this->conexion = Conexion::conectar(); 
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function obtenerNotaPorId($id) {
        try {
            $this->conectar();
            $id = trim($id);

            if ($id === '') {
                return null;
            }

            // Validación de tipo de datos
            if (!is_numeric($id)) {
                return null;
            }

            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, idUsuario FROM notas WHERE id = ?");
            $sentenciaSQL->execute([$id]);

            $nota = $sentenciaSQL->fetch(PDO::FETCH_OBJ);

            return $nota;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    public function modificarNota($id, $titulo, $contenido) {
        try {
            $this->conectar();
            $id = trim($id);
            $titulo = trim($titulo);
            $contenido = trim($contenido);

            if ($id === '' || $titulo === '' || $contenido === '') {
                return false;
            }

            // Validación de tipo de datos
            if (!is_numeric($id)) {
                return false;
            }

            if (strlen($titulo) > 255 || strlen($contenido) > 1000) {
                return false;
            }

            $sentenciaSQL = $this->conexion->prepare("UPDATE notas SET titulo = ?, contenido = ? WHERE id = ?");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $id]);

            return $result;

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para obtener todas las notas de un usuario
    public function obtenerNotasPorUsuario($idUsuario) {
        try {
            $this->conectar();
            $idUsuario = trim($idUsuario);

            // Validación de tipo de datos
            if (!is_numeric($idUsuario)) {
                return null;
            }

            // Consulta para obtener todas las notas de un usuario
            $sentenciaSQL = $this->conexion->prepare("SELECT id, titulo, contenido, idUsuario FROM notas WHERE idUsuario = ?");
            $sentenciaSQL->execute([$idUsuario]);

            $notas = [];
            while ($fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ)) {
                $notas[] = $fila;
            }

            return $notas;

        } catch(Exception $e) {
            var_dump($e);
            return null;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para eliminar una nota por su ID
    public function eliminarNota($id) {
        try {
            $this->conectar();
            $id = trim($id);

            if ($id === '') {
                return false;
            }

            // Validación de tipo de datos
            if (!is_numeric($id)) {
                return false;
            }

            // Consulta para eliminar una nota
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM notas WHERE id = ?");
            $result = $sentenciaSQL->execute([$id]);

            return $result; // Devuelve true si la eliminación fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

    // Método para agregar una nueva nota
    public function agregarNota($nota) {
        try {
            $this->conectar();
            $titulo = trim($nota->titulo);
            $contenido = trim($nota->contenido);
            $idUsuario = trim($nota->idUsuario);

            if ($titulo === '' || $contenido === '' || $idUsuario === '') {
                return false;
            }

            // Validación de tipo de datos
            if (!is_numeric($idUsuario)) {
                return false;
            }

            // Validación de longitud de datos
            if (strlen($titulo) > 255 || strlen($contenido) > 1000) {
                return false;
            }

            // Consulta para insertar una nueva nota
            $sentenciaSQL = $this->conexion->prepare("INSERT INTO notas (titulo, contenido, idUsuario) VALUES (?, ?, ?)");
            $result = $sentenciaSQL->execute([$titulo, $contenido, $idUsuario]);

            return $result; // Devuelve true si la inserción fue exitosa, false en caso contrario

        } catch(Exception $e) {
            var_dump($e);
            return false;
        } finally {
            Conexion::desconectar();
        }
    }
}
?>
