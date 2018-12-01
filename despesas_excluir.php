	
<?php
	
	require_once('bd.class.php');
	require_once("head.php");

	$cod = intval($_GET['desp']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();
	$sql = " DELETE FROM despesas WHERE id = '". $cod ."';";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
			<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=despesas.php?type=success&text=Despesa excluída com sucesso!&title=Sucesso '> ";
	}
	else{
		echo "
			<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=despesas.php?type=error&text=Não foi possível excluir a despesa!&title=Erro '> ";
	}
?>