// JavaScript Document
var ordenar = '';
$(document).ready(function(){
	
	// Llamando a la funcion de busqueda al
	// cargar la pagina
	filtrar()
	
	
	// filtrar al darle click al boton
	$("#btnfiltrar").click(function(){ filtrar(); });
	
	// boton cancelar
	$("#btncancel").click(function(){ 
		$(".filtro input").val('')
		$(".filtro select").find("option[value='0']").attr("selected",true)
		filtrar();
	});
	
	// ordenar por
	$("#data th span").click(function(){
		var orden = '';
		if($(this).hasClass("desc"))
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("asc");
			ordenar = "&orderby="+$(this).attr("title")+" asc"		
		}else
		{
			$("#data th span").removeClass("desc").removeClass("asc")
			$(this).addClass("desc");
			ordenar = "&orderby="+$(this).attr("title")+" desc"
		}
		filtrar()
	});
});

function filtrar()
{	
	$.ajax({
		data: $("#frm_filtro").serialize()+ordenar,
		type: "POST",
		dataType: "json",
		url: "ajax.php?action=listar",
			success: function(data){
				$('#result').html( data );
			}
	  });
}