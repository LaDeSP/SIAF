<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['inves']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "CALL plantiomensal_del('".$cod."'); ";
	$resultado = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link)){
		echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=plantiomensal.php?type=success&text=Plantio excluido!&title=Sucesso '> ";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=plantiomensal.php?type=error&text=Não foi possível excluir o plantio!&title=Erro '> ";
	}
?>