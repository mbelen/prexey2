var j = 0;

var ordenId;

var select_option = "";

var articulos = new Array();


function agregarOtro(){
	
  $('#agregar').hide();	
	   
  var nuevoBlock = $('<div class="prods" id="prods_' + j +'"></div>');
  
  var nuevoArticulo = $('<div class="articulo_nuevo" id="articulo_nuevo_'+j+'" style="margin-bottom:10px"></div>');
  
  var lblArticulo = $('<div class="label_producto" style="float:left">IMEI/SN</div>');
  
  var articulo = $('<input type="text" class="input_articulo"  id= "articulo_'+j+'" name="articulo_'+j+'" style="float:left;margin-left:5px">');
  
  var nuevoBoton = $('<div><input type="button" class="btn_agregar" id= "agregar'+j+'" name="agregar" value="agregar" data-art ="#articulo_'+j+'" style="float:left"></div>');

  var nuevoEliminar = $('<div><input type="button" class="btn_eliminar" id= "eliminar_'+j+'" data-art ="#articulo_'+j+'" name="eliminar" value="eliminar"></div>');
  
  nuevoArticulo.append(lblArticulo);
  
  nuevoArticulo.append(articulo);  
 
  nuevoArticulo.append(nuevoBoton);  
  
  nuevoArticulo.append(nuevoEliminar); 
    
  $('#productos').append(nuevoArticulo);  
  	
  
$('.btn_agregar').click(function(){
	
	var id = $(this).data('art');		

	var articulo = $(id).val();
	
	alert(articulo);
			
	if(articulos.indexOf(articulo) == -1){ 
	
		articulos.push(articulo);
	
		console.log(articulos);
	
		j++;
		
		console.log(j);
	
		agregarOtro();
	
	}else{
		
		alert("Ese articulo ya ha sido cargado");	
	}	
	
});

$('.btn_eliminar').click(function(){
	
	$("#sucess").html("");
	
	var id = $(this).data('art');		

	var articulo = $(id).val();
	
	var index = articulos.indexOf(articulo);
	
	articulos.splice(index,1);
	
	$('#productos').remove('#articulo_nuevo_'+index);
			
});	

} // agregar otro 

$(document).ready(function(){

	$('#productos').hide();
	//$('#crear').hide();
});
	
$("#agregar").click(function() {
	
  	
  var path=$("#agregar").data("url");	

  console.log(path);	
  
  if($('#backend_adminbundle_movimiento_documento').val().length <= 1){
	
	$('#backend_adminbundle_movimiento_documento_errorloc').html("Es un campo obligatorio");  
	 
  }else{  
	  
	  $('#backend_adminbundle_movimiento_documento_errorloc').html("");

	  $('#productos').show();
	  	
	  agregarOtro();	
	  
	  $('#crear').show();
	 
  }
  
}); 
	
$('#crear').click(function(){	
	 
	 var path = $(this).data('url');
	 
	  var parametros = {
					"origen" : $('#backend_adminbundle_movimiento_depositoOrigen').val(),
					"destino" : $('#backend_adminbundle_movimiento_depositoDestino').val(),
					"documento" : $('#backend_adminbundle_movimiento_documento').val(),
					"observaciones" : $('#backend_adminbundle_movimiento_observaciones').val(),
					"articulos": articulos 
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
						  
							alert("Se ha generado un error al cargar el movimiento");
							$("#respuesta").html("Se ha generado un error al cargar la orden de ingreso"); 
						 
						 }else{
							 
							
							alert("Se ha generado la orden de ingreso");
							$("#agregar").hide();
							
						 }                  
						  
					})
					.always(function(){					
							
						//$("#agregar").hide();
						
				});				
		
	  
});
