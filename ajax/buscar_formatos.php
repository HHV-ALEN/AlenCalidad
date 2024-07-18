<?php

/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
/* Connect To Database*/
require_once("../config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("../config/conexion.php"); //Contiene funcion que conecta a la base de datos
include('is_logged.php'); //Archivo verifica que el usario que intenta acceder a la URL esta logueado
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
if (isset($_GET['id'])) {
	$id_formato = intval($_GET['id']);
	$query = mysqli_query($con, "select * from formato where id_formato='" . $id_formato . "'");
	$rw_empleado = mysqli_fetch_array($query);
	$count = $rw_empleado['id_formato'];
	

	if ($id_formato > 0) {
		$sql = "update  formato set status='Eliminado' WHERE id_formato='" . $id_formato . "';";
		//Respaldo archivo
		$fh   = fopen("../txt/respaldo.txt", 'r+') or die("Ocurrio un error al abrir el archivo");
		fseek($fh, 0, SEEK_END);
		fwrite($fh, "$sql") or die("No se puede escribir en el archivo");
		fclose($fh);

		//Registro para la bitacora
		$sql_bitacora = $sql;
		$sql_bitacora = str_replace("'", "", $sql_bitacora);
		$nombre_usuario = $_SESSION['firstname'];
		$movimientos = $nombre_usuario . " elimino un formato (" . $codigo . ").";
		$fecha_bitacora = date("Y-m-d H:i:s");
		$sql1 = "INSERT INTO bitacora_movimientos( movimientos, movimientos_sql, fecha) VALUES ('$movimientos','$sql_bitacora','$fecha_bitacora');";
		$query_new_insert = mysqli_query($con, $sql1);

		if ($delete1 = mysqli_query($con, $sql)) {
?>
			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
		<?php
		} else {
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
		<?php

		}
	} else {
		?>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong><?php echo $id_formato; ?>Error!</strong> No se puede borrar el usuario administrador.
		</div>
	<?php
	}
}
if ($action == 'ajax') {
	// escaping, additionally removing everything that could be (html/javascript-) code
	$id_area = intval($_REQUEST['id_area']);
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('formato.procedimiento', 'formato.codigo'); //Columnas de busqueda
	$sTable = "formato";
	$sWhere = "where formato.status!='Eliminado'";
	$user_name = $_SESSION['user_name'];

	$sWhere .= " and  (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';

	if ($id_area > 0) {
		$sWhere .= " and formato.area='$id_area' ";
	}

	$sWhere .= "    order by  formato.id_formato  ";
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
	$per_page = 10; //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere ");
	$row = mysqli_fetch_array($count_query);
	$numrows = $row['numrows'];
	$total_pages = ceil($numrows / $per_page);
	$reload = './formatos.php';
	//main query to fetch the data
	$sql = "SELECT *  , formato.status as status1  FROM  $sTable inner join area on area.id_area=formato.area $sWhere   LIMIT $offset,$per_page";

	$query = mysqli_query($con, $sql);
	//loop through fetched data
	$sql1 = "SELECT * , formato.status as status1 FROM  $sTable inner join area on area.id_area=formato.area $sWhere ";
	$_SESSION["sql_reporte"] = $sql1;
	//echo $sql1;
	if ($numrows > 0) {

	?>
		<div class="table-responsive">
			<table class="table">
				<tr class="success">
					<th>Codigo</th>
					<th>Precedimiento</th>
					<th>Area</th>
					<th>Revisión</th>
					<th>Status</th>
					<th><span class="pull-right">Acciones</span></th>

				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$id_formato = $row['id_formato'];
					$codigo = $row['codigo'];
					$nombre_area = $row['nombre'];
					$procedimiento = $row['procedimiento'];
					$area = $row['area'];
					$numero_documento = $row['numero_documento'];
					$tipo_documento = $row['tipo_documento'];
					$revicion = $row['revicion'];
					$area = $row['area'];
					$status = $row['status1'];
				?>
					<input type="hidden" value="<?php echo $id_formato; ?>" id="id_formato<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $codigo; ?>" id="codigo<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $procedimiento; ?>" id="procedimiento<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $area; ?>" id="area<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $numero_documento; ?>" id="numero_documento<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $tipo_documento; ?>" id="tipo_documento<?php echo $id_formato; ?>">

					<tr>

						<td><?php echo $codigo; ?></td>
						<td><?php echo $procedimiento; ?></td>
						<td><?php echo $nombre_area; ?></td>
						<td><?php echo $revicion; ?></td>
						<td><?php echo $status; ?></td>

						<td><span class="pull-right">
							<?php
							if($user_name != 'ljarillo'){
								?>
								<a href="#" class='btn btn-default' title='Editar formato' data-procedimiento='<?php echo $procedimiento; ?>' data-tipo='<?php echo $tipo_documento; ?>' data-area='<?php echo $area; ?>' data-revicion='<?php echo $revicion; ?>' data-numero='<?php echo $numero_documento; ?>' data-status='<?php echo $status ?>' data-id='<?php echo $id_formato; ?>' data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
								<a href="#" class='btn btn-default' title='Borrar formato' onclick="eliminar('<?php echo $id_formato; ?>');"><i class="glyphicon glyphicon-trash"></i> </a></span>
								<?php
							}
							?>
						</td>

					</tr>
				<?php

				}
				?>
				<tr>
					<td colspan=9><span class="pull-right">
							<?php
							echo paginate($reload, $page, $total_pages, $adjacents);
							?></span></td>
				</tr>
			</table>
		</div>
<?php
	}
}
?>