<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version

	
if (empty($_POST['nombre'])){
			$errors[] = "Nombre vacíos";
		

		 
		

		} elseif (!empty($_POST['nombre'])
			&& !empty($_POST['nombre'])
			
          ){
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                
                $nombre = mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
				$siglas = mysqli_real_escape_string($con,(strip_tags($_POST["siglas"],ENT_QUOTES)));
				$link = mysqli_real_escape_string($con,(strip_tags($_POST["link"],ENT_QUOTES)));

				

				// crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				
             $sql = "INSERT INTO area (nombre, siglas, link,status) 
             VALUES('".$nombre."','".$siglas."','".$link."','ACTIVO');";
             
            $fh   = fopen("../txt/respaldo.txt", 'r+') or die("Ocurrio un error al abrir el archivo");
  			fseek($fh, 0, SEEK_END);
  			fwrite($fh, "$sql") or die("No se puede escribir en el archivo");
  			fclose($fh);

  			//Registro para la bitacora
                $sql_bitacora=$sql;
                $sql_bitacora = str_replace("'", "", $sql_bitacora);
                $nombre_usuario=$_SESSION['firstname'];
                $movimientos=$nombre_usuario." agrego una nueva área.";
                $fecha_bitacora=date("Y-m-d H:i:s");
                $sql1="INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
                $query_new_insert = mysqli_query($con,$sql1);
		 


                   $query_new_user_insert = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $messages[] = "La area  ha sido dado de alta con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    	
                    }
                }
            
         else {
            $errors[] = "Un error desconocido ocurrió.";
        
        }
		
		if (isset($errors)){
			
			?>
			<div class="alert alert-danger" role="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Error!</strong> 
					<?php
						foreach ($errors as $error) {
								echo $error;
							}
						?>
			</div>
			<?php
			}
			if (isset($messages)){
				
				?>
				<div class="alert alert-success" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Bien hecho!</strong>
						<?php
							foreach ($messages as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}

?>