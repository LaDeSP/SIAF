<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['estoq']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "Update estoques set quantidade=0 WHERE id = '". $cod. "';";

	$resultado = mysqli_query($link, $sql);
	if(mysqli_affected_rows($link) ){
		echo "
		   	<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php?type=success&text=Estoque excluída com sucesso!&title=Sucesso '> ";
	}
	else{
		echo "
		   	<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php?type=error&text=Não foi possível excluir a estoque!&title=Erro '>";
	}
?>