﻿	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Formato</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_empleado2" name="editar_empleado2">
			<div id="resultados_ajax2"></div>
			
							
			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Procedimiento:</label>
				<div class="col-sm-8">
					<input type="hidden" name="mod_id" id="mod_id">
			  
				  <input type="text" class="form-control" id="mod_procedimiento" name="mod_procedimiento" placeholder="Procedimiento" required>
				</div>
			  </div>
			
			  
			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Area</label>
				<div class="col-sm-8">
					<select class='form-control' name='mod_area' id='mod_area' onchange="load(1);">
							<option value="">Selecciona un área.</option>
							<?php 
							$query_area=mysqli_query($con,"select * from area where status!='INACTIVO' order by nombre");
							while($rw=mysqli_fetch_array($query_area))	{
								?>
							<option value="<?php echo $rw['id_area'];?>"><?php echo $rw['nombre'];?></option>			
								<?php
							}
							?>
						</select>
					</div>
			  </div>
			  


			   <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Tipo documento</label>
				<div class="col-sm-8">
						<select class='form-control' name='mod_tipo_documento' id='mod_tipo_documento' required>
						<option value="">Selecciona un tipo documento</option>
							<option value="DOCUMENTO EXTERNO">DOCUMENTO EXTERNO</option> 
							<option value="FORMATO">FORMATO</option> 
							<option value="INSTRUCTIVO">INSTRUCTIVO</option> 
							<option value="MANUAL">MANUAL</option> 
							<option value="POLÍTICA">POLÍTICA</option> 
							<option value="PROCEDIMIENTO">PROCEDIMIENTO</option> 
						</select>	

				</div>
			  </div>

			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Revisión:</label>
				<div class="col-sm-8">
				  <input type="number" class="form-control" id="mod_revicion" name="mod_revicion" placeholder="revision" required>
				</div>
			  </div>


			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Numero Documento:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_numero_documento" name="mod_numero_documento" placeholder="Numero documento" required>
				</div>
			  </div>
			  

			   <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Status</label>
				<div class="col-sm-8">
						<select class='form-control' name='mod_status' id='mod_status' required>
						<option value="">Selecciona un tipo documento</option>
							<option value="ACTIVO">ACTIVO</option> 
							<option value="DISPONIBLE">DISPONIBLE</option> 
						</select>	
				</div>
			  </div>
			  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos2">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>