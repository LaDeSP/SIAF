<?php
	
	require_once('bd.class.php');

	$cod = intval($_GET['prod']);

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$sql = " DELETE FROM produtos WHERE id = '$cod' ";

	$resultado = mysqli_query($link, $sql);

	if($resultado){
		echo "
		<script>
			alert('Produto excluido!');
			location.href='produtos.php';
		</script>";
	}
	else{
		echo "
		<script>
			alert('Não foi possível deletar o produto!');
			location.href='produtos.php';
		</script>";
	}
?>