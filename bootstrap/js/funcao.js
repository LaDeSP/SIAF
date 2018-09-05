$(function() {
	$("#id_estado").change(function(){
		var id = $(this).val();
		$.ajax({
			type: "POST",
			url: "exibe_cidade.php?id="+id,
			dataType:"text",
			success: function(res){
				$("#id_cidade").children(".cidades").remove();
				$("#id_cidade").append(res);
			}
		});
	});
});