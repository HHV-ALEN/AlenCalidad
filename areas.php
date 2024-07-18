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
$active_areas = "active";
$title = "Areas | ALEN Calidad";
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
					if ($user_name == "ljarillo"){

					}else{
						?>
					<button type='button' class="btn btn-success" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus"></span> Nueva Área</button>
					<?php
					}
					?>
				</div>
				<h4><i class='glyphicon glyphicon-search'></i> Buscar Área</h4>
			</div>

			<div class="panel-body">
				<?php
				include("modal/registro_areas.php");
				include("modal/editar_areas.php");
				?>
				<form class="form-horizontal" role="form" id="datos_cotizacion">
					<div class="form-group row">
						<div class='col-md-4'>
							<label>Filtrar por nombre o por siglas</label>
							<input type="text" class="form-control" id="q" placeholder="Nombre o siglas" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/areas2.js"></script>





</body>

</html>
<script>
	$("#editar_empleado2").submit(function(event) {
		$('#actualizar_datos2').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "ajax/editar_area.php",
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