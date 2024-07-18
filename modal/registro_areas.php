	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nueva área</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_empleado" name="guardar_empleado">
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
				</div>
			  </div>

			   <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Siglas:</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="siglas" name="siglas" placeholder="Siglas" required>
				</div>
			  </div>

			    <div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Link:</label>
				<div class="col-sm-8">
				  <textarea  class="form-control" id="link" name="link" placeholder="Siglas" required>
				  </textarea>	
				</div>
			  </div>
			
			
			  	

			   
			  

			 








			  

			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>