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
				url:'./ajax/buscar_areas.php',
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
			url: "ajax/editar_area.php",
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
	  var nombre = button.data('nombre') 
	  var siglas = button.data('siglas') 
	  var link = button.data('link') 
	  
	  var id = button.data('id') 
	  var modal = $(this)

	  modal.find('.modal-body #mod_link').val(link)
	  modal.find('.modal-body #mod_nombre').val(nombre)
	  modal.find('.modal-body #mod_siglas').val(siglas) 
	  modal.find('.modal-body #mod_id').val(id)
	})
		
		$( "#guardar_empleado" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_area.php",
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

		
		
		
		

