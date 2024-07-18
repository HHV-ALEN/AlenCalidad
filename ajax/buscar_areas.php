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

		if ($delete1 = mysqli_query($con, "update  formato set status='Eliminado' WHERE id_formato='" . $id_formato . "'")) {
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
	$q = mysqli_real_escape_string($con, (strip_tags($_REQUEST['q'], ENT_QUOTES)));
	$aColumns = array('nombre', 'siglas'); //Columnas de busqueda
	$sTable = "area";
	$sWhere = "where status!='INACTIVO'";
	$user_name = $_SESSION['user_name'];
	$sWhere .= "and  (";
	for ($i = 0; $i < count($aColumns); $i++) {
		$sWhere .= $aColumns[$i] . " LIKE '%" . $q . "%' OR ";
	}
	$sWhere = substr_replace($sWhere, "", -3);
	$sWhere .= ')';

	$sWhere .= "    order by  nombre  ";
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
	$reload = './areas.php';
	//main query to fetch the data
	$sql = "SELECT * FROM  $sTable $sWhere   LIMIT $offset,$per_page";
	//echo $sql;
	$query = mysqli_query($con, $sql);
	//loop through fetched data
	if ($numrows > 0) {

	?>
		<div class="table-responsive">
			<table class="table">
				<tr class="success">
					<th>Nombre</th>
					<th>Siglas</th>
					<th>Ubicación</th>

					<th><span class="pull-right">Acciones</span></th>

				</tr>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					$id_area = $row['id_area'];
					$nombre = $row['nombre'];
					$siglas = $row['siglas'];
					$link = $row['link'];

				?>

					<input type="hidden" value="<?php echo $id_area; ?>" id="id_area<?php echo $id_area; ?>">
					<input type="hidden" value="<?php echo $nombre; ?>" id="nombre<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $siglas; ?>" id="siglas<?php echo $id_formato; ?>">
					<input type="hidden" value="<?php echo $link; ?>" id="link<?php echo $id_formato; ?>">





					<tr>

						<td><?php echo $nombre; ?></td>
						<td><?php echo $siglas; ?></td>
						<td><a href="<?php echo $link; ?>" style='color:#000000;' role="button" target="_blank"> Link</a></td>
						<td><span class="pull-right">
							<?php 
							if($user_name != 'ljarillo'){
								?>
								<a href="#" class='btn btn-default' title='Editar formato' data-link='<?php echo $link; ?>' data-nombre='<?php echo $nombre; ?>' data-siglas='<?php echo $siglas; ?>' data-id='<?php echo $id_area; ?>' data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a>
								<?php
							}
							?>
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