<?php
/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: login.php");
	exit;
}

/* Connect To Database*/
require_once("config/db.php"); //Contiene las variables de configuracion para conectar a la base de datos
require_once("config/conexion.php"); //Contiene funcion que conecta a la base de datos
$active_empleados = "active";
$title = "Formatos | ALEN Calidad";
$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include("head.php"); ?>
</head>

<body>
	<?php
	include("navbar.php");
	?>
	<div class="container">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<?php					
					if($user_name != "ljarillo"){
						?>
					    <button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Nuevo Formato</button>
					<?php
					}
					?>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i> Buscar Formato</h4>
			</div>


			<div class="panel-body">
				<?php
				include("modal/registro_formatos.php");
				include("modal/editar_formatos.php");
				?>
				<form class="form-horizontal" role="form" id="datos_cotizacion">
					<div class="form-group row">
						<div class='col-md-4'>
							<label>Filtrar por código o por procedimiento</label>
							<input type="text" class="form-control" id="q" placeholder="Código o procedimiento" onkeyup='load(1);'>
						</div>
						<div class='col-md-3'>
							<label>Filtrar por área.</label>
							<select class='form-control' name='id_area' id='id_area' onchange="load(1);">
								<option value="">Selecciona un área.</option>
								<?php
								$query_area = mysqli_query($con, "select * from area where status!='INACTIVO' order by nombre");
								while ($rw = mysqli_fetch_array($query_area)) {
								?>
									<option value="<?php echo $rw['id_area']; ?>"><?php echo $rw['nombre']; ?></option>
								<?php
								}
								?>
							</select>
						</div>

						<div class='col-md-3'>
							<br>
							<a class="btn btn-success" href="reportes/reporte_excel_formatos.php" role="button"> Exporta a excel</a>
						</div>

					</div>



				</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->

			</div>
		</div>

	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/areas1.js"></script>





</body>

</html>
<script>
	$("#editar_empleado2").submit(function(event) {
		$('#actualizar_datos2').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/editar_formato.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			},
			success: function(datos) {
				$("#resultados_ajax2").html(datos);
				$('#actualizar_datos2').attr("disabled", false);
				load(1);
			}
		});
		event.preventDefault();
	})


	function get_empleado_id(id) {
		$("#empleado_id_mod").val(id);
	}

	function obtener_datos(id) {
		var nombres = $("#nombre" + id).val();
		var ubicacion = $("#ubicacion" + id).val();

		$("#mod_id").val(id);
		$("#nombre").val(nombres);
		$("#ubicacion").val(apellidos);

	}
</script>