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
				<label for="firstname" class="col-sm-3 control-label">Nombre:</label>
				<div class="col-sm-8">
					<input type="hidden" name="mod_id" id="mod_id">
			  
				  <input type="text" class="form-control" id="mod_nombre" name="mod_nombre" placeholder="Nombre" required>
				</div>
			  </div>
			
			<div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Siglas:</label>
				<div class="col-sm-8">
		
			  
				  <input type="text" class="form-control" id="mod_siglas" name="mod_siglas" placeholder="Nombre" required>
				</div>
			  </div>
			

			<div class="form-group">
				<label for="firstname" class="col-sm-3 control-label">Link:</label>
				<div class="col-sm-8">
				  <textarea  class="form-control" id="mod_link" name="mod_link" placeholder="Siglas" required>
				  </textarea>	
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