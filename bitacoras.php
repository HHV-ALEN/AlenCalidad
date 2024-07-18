<?php
	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }

	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_bitacoras="active";
	$title="Bitácora |ALEN Calidad";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				
				</div>
			<h4><i class='glyphicon glyphicon-search'></i> Bitácoras</h4>
		</div>
		<div class="panel-body">
		
			
			
			
			<form class="form-horizontal" role="form" id="datos">
				
						
				<div class="row">
					<div class='col-md-3'>
						<label>Inicio</label>
						 <input type="date" name="fecha_alta" id='fecha_alta'  class="form-control"   onchange='load(1);'>
                                                
					</div>
					
					<div class='col-md-3'>
						<label>Fin</label>
						 <input type="date" name="fecha_alta" id='fecha_fin'  class="form-control"   onchange='load(1);'>
					</div>

					
                                    

					<div class='col-md-12 text-center'>
						<span id="loader"></span>
					</div>
				</div>
				<hr>
				<div class='row-fluid'>
					<div id="resultados"></div><!-- Carga los datos ajax -->
				</div>	
				<div class='row'>
					<div class='outer_div'></div><!-- Carga los datos ajax -->
				</div>
			</form>
				
			
		
	
			
			
			
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/bitacoras.js"></script>
  </body>
</html>
