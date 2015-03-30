var j = 0;

var ordenId;

var select_option = "";

function generarMarcas(){

	  var path = $("#path").val();//"/prexey2/web/app_dev.php/panel/ordenIngreso/togeneratecombomarca";
  
  $.ajax({
					dataType: 'json',
					data:  {'marca':1},
					url:   path,
					type:  'post',
					})
					.done(function (data) {
					
						if(data.items!=null){
         					 $.each(data.items, function(i, value) {
								select_option = select_option + '<option value="'+value.id+'">'+value.nombre+'</option>';	 
								console.log("id:"+value.id+" nombre:"+value.nombre);
								console.log(select_option);
						    });
					    }				
				      
	});
			
}

function agregarOtro(){
	
  $('#productos').show();
 
  var nuevoBlock = $('<div class="prods" id="prods_' + j +'"></div>');
  
  var nuevoArticulo = $('<div class="producto_nuevo" id="producto_nuevo_'+j+'"></div>');
  
  var lblCant = $('<div class="label_producto">Cantidad</div>');
  
  var cantidad = $('<input type="text" class= "input_producto"  id= "cantidad_'+j+'" name="cantidad_'+j+'">');
  
  var lblMarca = $('<div class="label_producto">Marca</div>');
      
  var nuevaMarca = $('<div><select class="marca_select" id="marca_'+j+'" name="marca_'+j+'" data-url="togeneratecombo"><option value="0">Seleccione marca</option>'+select_option+'</select></div>');

  
  var lblModelo = $('<div class="label_producto">Modelo</div>');
  	
  var nuevoModelo = $('<div class="modelo_select"><select id="modelo_'+j+'"><option value="0">Seleccione modelo</option></select></div>');
	
  
  var nuevoBoton = $('<div><input type="button" class="btn_agregar" id= "'+j+'" name="agregar" value="agregar" data-url="toprocesadoingresos"></div>');

  var nuevoEliminar = $('<div><input type="button" class="btn_eliminar" id= "eliminar_'+j+'" name="eliminar" value="eliminar" data-url="toremoveingreso"></div>');
  
  nuevoArticulo.append(lblCant);
  
  nuevoArticulo.append(cantidad);  
    
  nuevoArticulo.append(lblMarca);
  
  nuevoArticulo.append(nuevaMarca);
  
  nuevoArticulo.append(lblModelo);
  
  nuevoArticulo.append(nuevoModelo);  
  
  nuevoArticulo.append(nuevoBoton);  
  
  nuevoArticulo.append(nuevoEliminar); 
    
  $('#productos').append(nuevoArticulo);  	

  j++;
  console.log(j);

  
  
$('.marca_select').change(function () {
  
      var id = $(this).attr('id');
	
	  console.log("id:"+id+"value:"+$(this).val());
	  
	  var modeloId = id.replace('marca_','modelo_');	  
	  
	  var path = $(this).data("url");
				
				$.ajax({
					dataType: 'json',
					data:  {'marca':$(this).val()},
					url:   path,
					type:  'post',
					})
					.done(function (data) {
						
						if(data.items!=null){
							
							$('#'+modeloId)
							.empty()
							.append('<option value="0">Seleccione modelo</option>')
							.find('option:first')
							.attr("selected","selected");
							
         					 $.each(data.items, function(i, value) {
						     $('#'+modeloId).append('<option value='+value.id+'>'+value.nombre+'</option>');
							 //console.log("id:"+value.id+" nombre:"+value.nombre);
						   });
					    }					
				
				
				});            
         });

  
$('.btn_agregar').click(function(){
	
	$("#sucess").html("");
	
	var id = $(this).attr('id');
				
	var path = $(this).data("url");
	
	console.log("valor: "+$('#cantidad_'+id).val());
	
	if($('#cantidad_'+id).val() == ""){ 
		
		$('#errores').html("Debe ingresar una cantidad");
		
	
	}else{		 
	
	    $('#errores').html("");
	
		var params = {
			
			'orden': ordenId,
			'cantidad':	$('#cantidad_'+id).val(),
			'marca': 	$('#marca_'+id).val(),	
			'modelo': 	$('#modelo_'+id).val()
		};
		
		console.log(params);
		
		$.ajax({
					dataType: 'json',
					data:  params,
					url:   path,
					type:  'post',
					})
					.done(function (data) {
												  								
						  if(data.resultado){						  
																					
							$("#sucess").html("Se agrego correctamente");	                  
						  
							agregarOtro();
						  
						  }
					})
					.always(function(){
						
						//agregarOtro();
						  
						$('#crear').show();							
						
					});	
			
	 } 	

});

$('.btn_eliminar').click(function(){
	
	$("#sucess").html("");
	
	var id = $(this).attr('id');
	
	var path = $(this).data("url");
	
	console.log("btn_id: "+id);
	
	var productoId = id.replace('eliminar_','producto_nuevo_');
		
	var cantidadId = id.replace('eliminar_','cantidad_');

	var cantidad = $('#'+cantidadId).val();
	
	var marcaId = id.replace('eliminar_','marca_');

	var marca = $('#'+marcaId).val();
	
	var modeloId = id.replace('eliminar_','modelo_');

	var modelo = $('#'+modeloId).val();
	
	var parametros = {
					"orden" : ordenId,
					"marca" : marca,
					"modelo" : modelo,
					"cantidad" : cantidad
		  };
	
		   $.ajax({
					dataType: 'json',
					data:  parametros,
					url:   path,
					type:  'post',
					})
					.done(function (data) {
						
						console.log(data.resultado);
						console.log(data.query);
											
						 if(!data.resultado){				  					
						  
							alert("Se ha generado un error al eliminar");
							$("#respuesta").html("Se ha generado un error al eliminar"); 
						 
						 }else{
							
							$('#'+productoId).hide(); 
							$("#sucess").html("El elemento se ha eliminado correctamente de la orden");				
						 
						 }                  
						  
					})
					.always(function(){					
							
						//$("#agregar").hide();						
					});					
	
	
});	

} // agregar otro 

$(document).ready(function(){

	generarMarcas();
	$('#productos').hide();
	$('#crear').hide();
});
	
$("#agregar").click(function() {
	
	
  var path=$("#agregar").data("url");	

  console.log(path);	
  
  if($('#backend_adminbundle_ordenIngreso_documento').val().length <= 1){
	
	$('#backend_adminbundle_ordenIngreso_documento_errorloc').html("Es un campo obligatorio");  
	 
  }else{  
	  
	  $('#backend_adminbundle_ordenIngreso_documento_errorloc').html("");

	  var parametros = {
					"cliente" : $('#backend_adminbundle_ordenIngreso_cliente').val(),
					"documento" : $('#backend_adminbundle_ordenIngreso_documento').val(),
					"operador" : $('#backend_adminbundle_ordenIngreso_operador').val(),
					"destino"  : $('#backend_adminbundle_ordenIngreso_deposito').val(),
					"observaciones" : $('#backend_adminbundle_ordenIngreso_observaciones').val()
		  };
		  
		  console.log(parametros);
		  
		  $.ajax({
					dataType: 'json',
					data:  parametros,
					url:   path,
					type:  'post',
					})
					.done(function (data) {
						
						console.log(data.resultado);
											
						 if(!data.resultado){				  					
						  
							alert("Se ha generado un error al cargar la orden de ingreso");
							$("#respuesta").html("Se ha generado un error al cargar la orden de ingreso"); 
						 
						 }else{
							 
							console.log("ID:"+data.id); 
							ordenId = data.id;
							console.log("orden"+ordenId); 
							console.log("estado"+data.estado);
							console.log("area"+data.area);
							//alert("Se ha generado la orden de ingreso");
							$("#agregar").hide();
							agregarOtro();
						 
						 }                  
						  
					})
					.always(function(){					
							
						//$("#agregar").hide();
						
				});				
		
	  
}
             
});
