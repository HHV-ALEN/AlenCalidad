<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}		
		if (empty($_POST['mod_nombre'])){
			$errors[] = "Nombre vacíos";
		} elseif (
			!empty($_POST['mod_nombre']))
         {
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
               $mod_nombre = mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
				$mod_siglas = mysqli_real_escape_string($con,(strip_tags($_POST["mod_siglas"],ENT_QUOTES)));
				$mod_link = mysqli_real_escape_string($con,(strip_tags($_POST["mod_link"],ENT_QUOTES)));
				$mod_id = mysqli_real_escape_string($con,(strip_tags($_POST["mod_id"],ENT_QUOTES)));

				
				

				

               

					// write new user's data into database
                    $sql = "UPDATE area SET nombre='".$mod_nombre."',siglas ='".$mod_siglas."' , link='".$mod_link."' 
                            WHERE id_area='".$mod_id."';";

                            	$fh   = fopen("../txt/respaldo.txt", 'r+') or die("Ocurrio un error al abrir el archivo");
								fseek($fh, 0, SEEK_END);
  								fwrite($fh, "$sql") or die("No se puede escribir en el archivo");
  								fclose($fh); 

  					//Registro para la bitacora
                $sql_bitacora=$sql;
                $sql_bitacora = str_replace("'", "", $sql_bitacora);
                $nombre_usuario=$_SESSION['firstname'];
                $movimientos=$nombre_usuario." actualizo un área.";
                $fecha_bitacora=date("Y-m-d H:i:s");
                $sql1="INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
                $query_new_insert = mysqli_query($con,$sql1);



                    $query_update = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_update) {
                        $messages[] = "La cuenta ha sido modificada con éxito.";
                        echo"<script language='javascript'>window.location='areas.php'
            			</script>;";

                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                
            
        } else {
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