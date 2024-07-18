		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var fecha_alta= $("#fecha_alta").val();
                        
			var fecha_fin= $("#fecha_fin").val();
			var id_usuario= $("#id_usuario").val();
			var parametros={'action':'ajax','page':page,'fecha_alta':fecha_alta,'fecha_fin':fecha_fin};
			$("#loader").fadeIn('slow');
			$.ajax({
				data: parametros,
				url:'./ajax/buscar_bitacora.php',
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
		
		
		
		
		
		
		
		

