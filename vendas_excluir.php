<?php

	require_once('bd.class.php');

	$cod = intval($_GET['venda']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "CALL vendas_del('$cod'); ";
	$resultado = mysqli_query($link, $sql);
	
	if(mysqli_affected_rows($link)){
		echo "
		    <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php?type=success&text=Venda excluída com sucesso!&title=Sucesso'>";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php?type=error&text=Não foi possível excluir a venda!&title=Erro '>";
	}
?>