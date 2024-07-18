<?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	//Archivo de funciones PHP
	include("../funciones.php");
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_producto=intval($_GET['id']);
		if ($delete1=mysqli_query($con,"DELETE FROM products WHERE id_producto='".$id_producto."'")){
		?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		 
		
		
		
	}
	if($action == 'ajax'){
	date_default_timezone_set("America/Mexico_City");
        $mes=date("m");
        $ano=date("Y");
        $dia=date("d");
        $fechafin=$ano."-".$mes."-".$dia;
        $fechaalta='2021-01-01'; 
            

// escaping, additionally removing everything that could be (html/javascript-) code
         
	 $fecha_alta = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_alta'], ENT_QUOTES)));
         $fecha_fin = mysqli_real_escape_string($con,(strip_tags($_REQUEST['fecha_fin'], ENT_QUOTES)));
       
                
         
         
         
                 
		 $sTable = "bitacora_movimientos";
		 $sWhere = "";
		
		
                  if (!empty($fecha_alta) && empty($fecha_fin) ){
             
            $sWhere .=" where DATE(fecha) BETWEEN '$fecha_alta' AND '$fechafin'   ";
        }else if (!empty($fecha_alta) && !empty($fecha_fin) ) {
            $sWhere .="  where DATE(fecha) BETWEEN '$fecha_alta' AND '$fecha_fin'   ";
            
        }else if (empty($fecha_alta) && !empty($fecha_fin) ) {
            $sWhere .="  where DATE(fecha) BETWEEN '$fechaalta' AND '$fecha_fin'  ";
            
        }
                 
		
		
		
		
		$sWhere.=" order by id_bitacora_movimientos desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 18; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './bitacoras.php';
		//main query to fetch the data
		
                $sql="SELECT *  FROM  $sTable $sWhere LIMIT $offset,$per_page";
	
		$query = mysqli_query($con, $sql);
		

		//loop through fetched data
		if ($numrows>0){
			
			?>

				<div class="table-responsive">
			    <table class="table">
				<tr  class="success">
					<th>Fecha</th>
					<th>Movimientos</th>
					<th>SQL</th>
					
					
					
					
					
					

			  
				<?php
				$nums=1;
				$total=0;
				while ($row=mysqli_fetch_array($query)){
						$fecha=$row['fecha'];
						$movimientos=$row['movimientos'];
                                                $movimientos_sql=$row['movimientos_sql'];
						//codigo la imagen
			   			
					?>

					
					<tr>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $movimientos; ?></td>
						<td><?php echo $movimientos_sql; ?></td>
						
					</tr>

			    
					<?php
					
					?>
					
					<?php
					if ($nums%6==0){
						echo "<div class='clearfix'></div>";
					}
					$nums++;
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
