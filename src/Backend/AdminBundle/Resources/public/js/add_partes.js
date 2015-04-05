var j = 0;

var ordenId;

function generarCombo() {
  
  	 		   
	  var path = $("#path").val(); 
				
				$.ajax({
					dataType: 'json',
					data:  {'val':1},
					url:   path,
					type:  'post',
					})
					.done(function (data) {
						
						if(data.items!=null){
							
							console.log("j en el combo:"+j);
							
							var k = j - 1;
							
							$('#parte_'+k)
							.empty()
							.append('<option value="0">Seleccione codigo de parte</option>')
							.find('option:first')
							.attr("selected","selected");
							
         					 $.each(data.items, function(i, value) {
								$('#parte_'+k).append('<option value='+value.id+'>'+value.codigo+'</option>');
							 
						     });
					    }				
				
				});  
  
}  


function agregarOtro(){
	
  $('#partes').show();
 
  var nuevoBlock = $('<div class="prods" id="prods_' + j +'"></div>');
    
  var nuevoArticulo = $('<div class="producto_nuevo" id="art_' + j +'"></div>');
  
  var lblCant = $('<div class="label_producto">Cantidad</div>');
  
  var cantidad = $('<input type="text" class= "input_producto"  id= "cantidad_'+j+'" name="cantidad_'+j+'">');
 
  var lblParte = $('<div class="label_producto">Parte</div>');
      
  var nuevaParte = $('<div><select class="parte_select" id="parte_'+j+'" name="parte_'+j+'"></select></div>');    
  
  var nuevoBoton = $('<div><input type="button" class="btn_agregar" id= "'+j+'" name="agregar" value="agregar" data-url="toprocesadoingresos"></div>');

  var nuevoEliminar = $('<div><input type="button" class="btn_eliminar" id= "eliminar_'+j+'" name="eliminar" value="eliminar"></div>');
	
  
  nuevoArticulo.append(lblCant);
  
  nuevoArticulo.append(cantidad);  
    
  nuevoArticulo.append(lblParte);
      
  nuevoArticulo.append(nuevaParte);  
    
  nuevoArticulo.append(nuevoBoton);  
  
  nuevoArticulo.append(nuevoEliminar); 
    
  $('#partes').append(nuevoArticulo);  	

  generarCombo();	

  j++;
  console.log(j);

  
$('.btn_agregar').click(function(){
			
	var errores = 0;
	
	$("#sucess").html("");
	
	var id = $(this).attr('id');
			
	console.log("valor: "+$('#cantidad_'+id).val());
	
	if($('#cantidad_'+id).val() == ""){ 
		
		$('#errores').html("Debe ingresar una cantidad");
		
		errores++;
	}
	
	if($('#parte_'+id).val() == "0"){
	
		$('#errores').html("Debe seleccionar un codigo de parte");
		
		errores++;			
	}		
	
	if(errores == 0){		 
	
		var path = $(this).data("url");
		
	    $('#errores').html("");
	
		var params = {
			
			'orden': ordenId,
			'cantidad':	$('#cantidad_'+id).val(),
			'parte': 	$('#parte_'+id).val()
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
											  
						$('#crear').show();							
						
					});	
			
	 } // if-else 	

});

$('.btn_eliminar').click(function(){
	
	var id = $(this).attr('id');
	
	var art = id.replace('eliminar_','art_');
	
	console.log(art);
	
	$('#'+art).hide();	
	
	var i = id.replace('eliminar_',"");
	
	console.log(i);
	
	if(i == 0 || (i == (j-1))){
	
		console.log("mostrar boton agregar");
	
	}else{
		
	   console.log("solo ocultar");
	}
	
});	

} 

$(document).ready(function(){


	$('#partes').hide();
	$('#crear').hide();
	
});
	
$("#agregar").click(function() {
	
	
  var path=$("#agregar").data("url");	

  console.log(path);
  console.log($('#backend_adminbundle_ordenIngresoParte_destino').val());	
  
  if($('#backend_adminbundle_ordenIngresoParte_documento').val().length <= 1){
	
	$('#backend_adminbundle_ordenIngresoParte_documento_errorloc').html("Es un campo obligatorio");  
	 
  }else{  
	  
	  $('#backend_adminbundle_ordenIngresoParte_documento_errorloc').html("");

	  var parametros = {
					"cliente" : $('#backend_adminbundle_ordenIngresoParte_cliente').val(),
					"documento" : $('#backend_adminbundle_ordenIngresoParte_documento').val(),
					"operador" : $('#backend_adminbundle_ordenIngresoParte_operador').val(),
					"observaciones" : $('#backend_adminbundle_ordenIngresoParte_observaciones').val(),
					"destino": $('#backend_adminbundle_ordenIngresoParte_deposito').val()
		  };
		  
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
							//alert("Se ha generado la orden de ingreso");
							$("#agregar").hide();
						 
						 }                  
						  
					})
					.always(function(){					
							
						//$("#agregar").hide();
						
				});
				
		
	  agregarOtro();
}
             
});
