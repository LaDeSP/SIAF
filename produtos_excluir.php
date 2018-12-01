<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['prod']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = "CALL produtos_del('".$cod."'); ";
	$resultado = mysqli_query($link, $sql);

	if(mysqli_affected_rows($link)){
		echo "<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=produtos.php?type=success&text=Produto excluido!&title=Sucesso '> ";
	}
	else{
		echo "
		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=produtos.php?type=error&text=Não foi possível excluir o produto!&title=Erro '> ";
	}
?>