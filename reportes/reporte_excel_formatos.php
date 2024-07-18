<meta charset="utf-8">
<?php	
	date_default_timezone_set("America/Mexico_City");	
//header("Content-Type: application/xls ");
//header("Content-Disposition: attachment; filename=archivo.xls");
session_start();
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");
$sql=$_SESSION["sql_reporte"];

//Registro para la bitacora
                $sql_bitacora=$sql;
                $sql_bitacora = str_replace("'", "", $sql_bitacora);
                $nombre_usuario=$_SESSION['firstname'];
                $movimientos=$nombre_usuario." exporto un archivo a Excel.";
                $fecha_bitacora=date("Y-m-d H:i:s");
                $sql1="INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
                $query_new_insert = mysqli_query($con,$sql1);
            


header('Content-Type:application/xls; charset=latin1');
header('Content-Disposition: attachment; filename="Reportes Formatos.xls"');

$query = mysqli_query($con, $sql);



	?>
<table  border="1">
    <tr>
        <th>Código</th>
        <th>Procedimiento</th>
        <th>Área</th>
	<th>Tipo Documento</th>
	<th>Revisión</th>
	<th>Numero Documento</th>
	<th>Status</th>
	
     </tr>
        
        
        <?php
				while ($row=mysqli_fetch_array($query)){
						$codigo=$row['codigo'];
						$procedimiento=$row['procedimiento'];
						$nombre_area=$row['nombre'];
						$tipo_documento=$row['tipo_documento'];
						$revicion=$row['revicion'];
			   			$numero_documento=$row['numero_documento'];
			   			$status=$row['status1'];
			   			
			   			

			   			
					?>

					
					<tr>
						<td><?php echo $codigo; ?></td>
						<td><?php echo $procedimiento; ?></td>
						<td><?php echo $nombre_area; ?></td>
						<td ><?php echo $tipo_documento; ?></td>
						<td><?php echo $revicion; ?></td>
						<td><?php echo $numero_documento; ?></td>
						<td><?php echo $status; ?></td>
						</tr>

			    
					
					
					<?php
					
				}
				?>
				

				
		
</table>