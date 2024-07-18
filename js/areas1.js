		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
                        var id_area= $("#id_area").val();
			var parametros={'action':'ajax','page':page,'q':q,'id_area':id_area};
			$("#loader").fadeIn('slow');
			$.ajax({
				data: parametros,
				url:'./ajax/buscar_formatos.php',
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el formato")){	
		$.ajax({
        type: "GET",
        url: "./ajax/buscar_formatos.php",
        data: "id="+id,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}


	


$( "#editar_empleado" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_formato.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

	
	$('#myModal2').on('show.bs.modal', function (event) {
	  var button = $(event.relatedTarget) // Button that triggered the modal
	  var procedimiento = button.data('procedimiento') 
	  var tipo = button.data('tipo') 
	  var revicion = button.data('revicion') 
	  var numero = button.data('numero') 
	  var area = button.data('area') 
	  var status = button.data('status') 
	  var id = button.data('id') 
	  var modal = $(this)
	  
	  modal.find('.modal-body #mod_procedimiento').val(procedimiento)
	  modal.find('.modal-body #mod_tipo_documento').val(tipo) 
	  modal.find('.modal-body #mod_revicion').val(revicion)
	  modal.find('.modal-body #mod_numero_documento').val(numero)
	  modal.find('.modal-body #mod_area').val(area) 
	  modal.find('.modal-body #mod_status').val(status)
	  modal.find('.modal-body #mod_id').val(id)
	})
		
		$( "#guardar_empleado" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_formato.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

		
		
		
		

