<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['inves']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = " DELETE FROM investimentos WHERE id = '$cod' ";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=investimentos.php'>
		<script type=\"text/javascript\">
		  alert(\"Investimento excluído!\");
		</script>
		";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=investimentos.php'>
		<script type=\"text/javascript\">
		  alert(\"Não foi possível excluir o investimento!\");
		</script>
		";
	}
?>