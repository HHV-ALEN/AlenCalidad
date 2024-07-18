<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
date_default_timezone_set("America/Mexico_City");	
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}		
		if (empty($_POST['mod_procedimiento'])){
			$errors[] = "Procedimiento vacíos";
		} elseif (empty($_POST['mod_area'])) {
            $errors[] = "Revicion esta vacio";
        } elseif (
			!empty($_POST['mod_procedimiento'])
			&& !empty($_POST['mod_area'])
			
          )
         {
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                $mod_procedimiento = mysqli_real_escape_string($con,(strip_tags($_POST["mod_procedimiento"],ENT_QUOTES)));
				$mod_area = mysqli_real_escape_string($con,(strip_tags($_POST["mod_area"],ENT_QUOTES)));
				$mod_tipo_documento = mysqli_real_escape_string($con,(strip_tags($_POST["mod_tipo_documento"],ENT_QUOTES)));
				$mod_revicion = mysqli_real_escape_string($con,(strip_tags($_POST["mod_revicion"],ENT_QUOTES)));
				$mod_numero_documento = mysqli_real_escape_string($con,(strip_tags($_POST["mod_numero_documento"],ENT_QUOTES)));
				$mod_status = mysqli_real_escape_string($con,(strip_tags($_POST["mod_status"],ENT_QUOTES)));
				$formato_id=intval($_POST['mod_id']);
				
				if ($mod_tipo_documento=="DOCUMENTO EXTERNO") {
					$codigo_tipo="X";
				} else if ($mod_tipo_documento=="FORMATO") {
					$codigo_tipo="F";
				} else if ($mod_tipo_documento=="INSTRUCTIVO") {
					$codigo_tipo="I";
				}else if ($mod_tipo_documento=="MANUAL") {
					$codigo_tipo="M";
				} else if ($mod_tipo_documento=="POLÍTICA") {
					$codigo_tipo="PE";
				}else{
					$codigo_tipo="P";
				}

				$sqlo="SELECT * FROM  area where  id_area='$mod_area'";
				$queryo = mysqli_query($con, $sqlo);
				$rowo=mysqli_fetch_array($queryo);
				$codigo_area=$rowo['siglas'];
				$codigo=$codigo_area."-".$codigo_tipo."-".$mod_numero_documento;





				//Consulta de  la validacion del sistema
				$sqli="SELECT * FROM  formato where  codigo='$codigo' and id_formato!='$formato_id'";
				$queryi = mysqli_query($con, $sqli);
				$rowi=mysqli_fetch_array($queryi);
				$validacion=$rowi['id_formato'];
				

				$sqlu="SELECT * FROM  formato where   id_formato='$formato_id'";
				$queryu = mysqli_query($con, $sqlu);
				$rowu=mysqli_fetch_array($queryu);
				$validacion_status=$rowu['status'];

				//Movimientos de la bitacora
				$nombre_usuario=$_SESSION['firstname'];
				if ($validacion_status==$mod_status) {
					$movimientos=$nombre_usuario." actualizo un formato (".$codigo.").";
				} elseif($mod_status=='DISPONIBLE') {
					$movimientos=$nombre_usuario." cambio el status de un formato (".$codigo.") de activo a disponible.";
				}else{
				
					$movimientos=$nombre_usuario." reactivo un formato (".$codigo.").";
				}
				

			if ($validacion<1  ) {


                  

					// write new user's data into database
                    $sql = "UPDATE formato SET procedimiento='".$mod_procedimiento."'   , area='".$mod_area."' , tipo_documento='".$mod_tipo_documento."' , revicion='".$mod_revicion."' , numero_documento='".$mod_numero_documento."', status='".$mod_status."',codigo='".$codigo."'
                            WHERE id_formato='".$formato_id."';";

                       $sql_bitacora=$sql;
                	   $sql_bitacora = str_replace("'", "", $sql_bitacora);
                	   $fecha_bitacora=date("Y-m-d H:i:s");
                	   $sql1="INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
                	   $query_new_insert = mysqli_query($con,$sql1); 
                     	
                     	$fh   = fopen("../txt/respaldo.txt", 'r+') or die("Ocurrio un error al abrir el archivo");
  						fseek($fh, 0, SEEK_END);
  						fwrite($fh, "$sql") or die("No se puede escribir en el archivo");
  						fclose($fh); 

                    $query_update = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_update) {
                        $messages[] = "La cuenta ha sido modificada con éxito.";
                        echo"<script language='javascript'>window.location='formatos.php'
            			</script>;";

                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo.";
                    }
                    } else {
				$errors[] = "Codigo repetido.";
			}
                
            
        } else {
            $errors[] = "1111 Un error desconocido ocurrió.";
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