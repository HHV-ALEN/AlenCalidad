<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
date_default_timezone_set("America/Mexico_City");	
	
if (empty($_POST['procedimiento'])){
			$errors[] = "Procedimiento vacíos";
		

		 
		

		} elseif (!empty($_POST['procedimiento'])
			&& !empty($_POST['procedimiento'])
			
          ){
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                
                $procedimiento = mysqli_real_escape_string($con,(strip_tags($_POST["procedimiento"],ENT_QUOTES)));
				$area = mysqli_real_escape_string($con,(strip_tags($_POST["area"],ENT_QUOTES)));
				$tipo_documento=mysqli_real_escape_string($con,(strip_tags($_POST["tipo_documento"],ENT_QUOTES)));
				$revision=mysqli_real_escape_string($con,(strip_tags($_POST["revision"],ENT_QUOTES)));
				$numero_documento=mysqli_real_escape_string($con,(strip_tags($_POST["numero_documento"],ENT_QUOTES)));
				
				

				// crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				if ($tipo_documento=="DOCUMENTO EXTERNO") {
					$codigo_tipo="X";
				} else if ($tipo_documento=="FORMATO") {
					$codigo_tipo="F";
				} else if ($tipo_documento=="INSTRUCTIVO") {
					$codigo_tipo="I";
				}else if ($tipo_documento=="MANUAL") {
					$codigo_tipo="M";
				} else if ($tipo_documento=="POLÍTICA") {
					$codigo_tipo="PE";
				}else{
					$codigo_tipo="P";
				}


				$sqlo="SELECT * FROM  area where  id_area='$area'";
				$queryo = mysqli_query($con, $sqlo);
				$rowo=mysqli_fetch_array($queryo);
				$codigo_area=$rowo['siglas'];

				
				$codigo=$codigo_area."-".$codigo_tipo."-".$numero_documento;

			
			$sqli="SELECT * FROM  formato where  codigo='$codigo'";
				$queryi = mysqli_query($con, $sqli);
				$rowi=mysqli_fetch_array($queryi);
				$validacion=$rowi['id_formato'];

			if ($validacion<1) {
			$sql = "INSERT INTO formato (procedimiento, area, tipo_documento, codigo, revicion, numero_documento, status) 
             VALUES('".$procedimiento."','".$area."','".$tipo_documento."','".$codigo."','".$revision."','".$numero_documento."','ACTIVO');";
                   $query_new_user_insert = mysqli_query($con,$sql);
			
			//Respaldo archivo 
			$fh   = fopen("../txt/respaldo.txt", 'r+') or die("Ocurrio un error al abrir el archivo");
  			fseek($fh, 0, SEEK_END);
  			fwrite($fh, "$sql") or die("No se puede escribir en el archivo");
  			fclose($fh); 

  			 //Registro para la bitacora
                $sql_bitacora=$sql;
                $sql_bitacora = str_replace("'", "", $sql_bitacora);
                $nombre_usuario=$_SESSION['firstname'];
                $movimientos=$nombre_usuario." agrego un nuevo formato (".$codigo.").";
                $fecha_bitacora=date("Y-m-d H:i:s");
                $sql1="INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
                $query_new_insert = mysqli_query($con,$sql1);


				if ($query_new_user_insert) {
                        $messages[] = "El formato ha sido dado de alta con éxito.";
                    }else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    	}
			} else {
				$errors[] = "Codigo repetido.";
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