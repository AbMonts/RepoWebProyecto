<?php
//importa la clase conexión y el modelo para usarlos
require_once 'conexion.php'; 
require_once '../modelos/Usuario.php'; 

class DAOUsuario
{
    
	private $conexion; 
    
    /**
     * Permite obtener la conexión a la BD
     */
    private function conectar(){
        try{
			$this->conexion = Conexion::conectar(); 
		}
		catch(Exception $e)
		{
			die($e->getMessage()); /*Si la conexion no se establece se cortara el flujo enviando un mensaje con el error*/
		}
    }
    
    public function autenticar($correo, $password)
    {
        try
        {
            $this->conectar();
            $obj = null;
            
            $correo = trim($correo);
            $password = trim($password);
    
            $sentenciaSQL = $this->conexion->prepare("SELECT id, nombre, apellido1, apellido2, rol, contrasena 
                FROM usuarios WHERE correo = ?");
            $sentenciaSQL->execute([$correo]);
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            
            //var_dump($fila);
    
            if ($fila) {
                //var_dump($password, $fila->contrasena);
                if ($password === $fila->contrasena) { // Verificación directa de la contraseña (no recomendado)
                    $obj = new Usuario();
                    $obj->id = $fila->id;
                    $obj->nombre = $fila->nombre;
                    $obj->apellido1 = $fila->apellido1;
                    $obj->apellido2 = $fila->apellido2;
                    $obj->rol = $fila->rol;
    
                   // var_dump('cuando entro al if: ', $obj);
                    return $obj;
                }
            }
            //var_dump($obj);
            return $obj;
        }
        catch(Exception $e){
            var_dump($e);
            return null;
        }
        finally{
            Conexion::desconectar();
        }
    }
    

    
    

   /**
    * Metodo que obtiene todos los usuarios de la base de datos y los
    * retorna como una lista de objetos  
    */
	public function obtenerTodos()
	{
		try
		{
            $this->conectar();
            
			$lista = array();
            /*Se arma la sentencia sql para seleccionar todos los registros de la base de datos*/
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2, correo,rol FROM usuarios");
			
            //Se ejecuta la sentencia sql, retorna un cursor con todos los elementos
			$sentenciaSQL->execute();
            
            //$resultado = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_OBJ);
            /*Podemos obtener un cursor (resultado con todos los renglones como 
            un arreglo de arreglos asociativos o un arreglo de objetos*/
            /*Se recorre el cursor para obtener los datos*/
			
            foreach($resultado as $fila)
			{
				$obj = new Usuario();
                $obj->id = $fila->id;
	            $obj->nombre = $fila->nombre;
	            $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
	            $obj->correo = $fila->correo;
                $obj->rol = $fila->rol;
				//Agrega el objeto al arreglo, no necesitamos indicar un índice, usa el próximo válido
                $lista[] = $obj;
			}
            
			return $lista;
		}
		catch(PDOException $e){
            var_dump($e);
			return null;
		}finally{
            Conexion::desconectar();
        }
	}
    
    /**
     * Metodo que obtiene un registro de la base de datos, retorna un objeto  
     */
    public function obtenerUno($id)
	{
		try
		{ 
            $this->conectar();
            
            //Almacenará el registro obtenido de la BD
			$obj = null; 
            
			$sentenciaSQL = $this->conexion->prepare("SELECT id,nombre,apellido1,apellido2,correo,rol FROM usuarios WHERE id=?"); 
			//Se ejecuta la sentencia sql con los parametros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            /*Obtiene los datos*/
			$fila=$sentenciaSQL->fetch(PDO::FETCH_OBJ);
			
            $obj = new Usuario();
            
            $obj->id = $fila->id;
            $obj->nombre = $fila->nombre;
            $obj->apellido1 = $fila->apellido1;
            $obj->apellido2 = $fila->apellido2;
            $obj->rol = $fila->rol;
           
            return $obj;
		}
		catch(Exception $e){
            return null;
		}finally{
            Conexion::desconectar();
        }
	}
        
    /**
     * Elimina el usuario con el id indicado como parámetro
     */
	public function eliminar($id)
	{
		try 
		{
			$this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare("DELETE FROM usuarios WHERE id = ?");			          
			$resultado=$sentenciaSQL->execute(array($id));
			return $resultado;
		} catch (PDOException $e) 
		{
			//Si quieres acceder expecíficamente al numero de error
			//se puede consultar la propiedad errorInfo
			return false;	
		}finally{
            Conexion::desconectar();
        }
 
	}


    public function actualizar(Usuario $obj)
    {
        try {
            $sql = "UPDATE usuarios
                    SET
                    nombre = ?,
                    correo = ?,
                    usuario = ?,
                    apellido1 = ?,
                    apellido2 = ?,
                    rol = ?,
                    contrasena = ?
                    WHERE id = ?";

            $this->conectar();
            
            $sentenciaSQL = $this->conexion->prepare($sql);
            $sentenciaSQL->execute(
                array(
                    $obj->nombre,
                    $obj->correo,
                    $obj->usuario,
                    $obj->apellido1,
                    $obj->apellido2,
                    $obj->rol,
                    $obj->contrasena,
                    $obj->id
                )
            );
            return true;
        } catch (PDOException $e) {
            // Si quieres acceder específicamente al número de error se puede consultar la propiedad errorInfo
            return false;
        } finally {
            Conexion::desconectar();
        }
    }

	

    public function obtenerPorId($id)
    {
        try { 
            $this->conectar();
            
            // Almacenará el registro obtenido de la BD
            $obj = null; 
            
            $sentenciaSQL = $this->conexion->prepare("SELECT id, nombre, correo, apellido1, apellido2, rol, contrasena FROM usuarios WHERE id=?;"); 
            // Se ejecuta la sentencia SQL con los parámetros dentro del arreglo 
            $sentenciaSQL->execute([$id]);
            
            // Obtiene los datos
            $fila = $sentenciaSQL->fetch(PDO::FETCH_OBJ);
            
            if ($fila) {
                $obj = new Usuario();
                $obj->id = $fila->id;
                $obj->nombre = $fila->nombre;
                $obj->correo = $fila->correo;
                $obj->apellido1 = $fila->apellido1;
                $obj->apellido2 = $fila->apellido2;
                $obj->rol = $fila->rol;
                $obj->contrasena = $fila->contrasena;
            }
           // var_dump($obj);
            return $obj;
        } catch(Exception $e) {
            return null;
        } finally {
            Conexion::desconectar();
        }
    }
	


    public function agregar(Usuario $obj)
{
    $clave = 0;
    try {
        $sql = "INSERT INTO usuarios (nombre, apellido1, apellido2, correo, usuario, rol, contrasena) 
                VALUES (:nombre, :apellido1, :apellido2, :correo, :usuario, :rol, :contrasena)";
                
        $this->conectar();
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':nombre' => $obj->nombre,
            ':apellido1' => $obj->apellido1,
            ':apellido2' => $obj->apellido2,
            ':correo' => $obj->correo,
            ':usuario' => $obj->usuario,
            ':rol' => $obj->rol,
            ':contrasena' => $obj->contrasena // Asegúrate de cifrar la contraseña si es necesario
        ]);
        $clave = $this->conexion->lastInsertId();
        return $clave;
    } catch (Exception $e){
        return $clave;
    } finally {
        Conexion::desconectar();
    }
}

}