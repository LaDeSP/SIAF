<!DOCTYPE html>
<html>
<head>
	<title>Relatorio de Vendas</title>
	<?php require_once("head.php")  ?>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div>
	<?php require_once("menu.php");	?>	
</div>

<?php
	session_start();
	require_once 'bd.class.php';
	require_once 'funcoes.php';
	

	
	$objBd = new bd();
	$query='SELECT pp.data,p.nome_produto,p.unidade,pp.quantidade,pp.motivo FROM perda_produtos pp INNER JOIN produtos p on pp.produtos_id=p.id INNER JOIN estoques e on pp.estoques_id=e.id WHERE e.proprietarios_id=? order by pp.data';
	$param=array( );
	$param[0]=$_SESSION['id'];
	$type="s";
	$result=$objBd->exec($query,$type,$param);
	?>
	<div class="table-responsive" >
	<table class=" table table-striped table-hover table-condensed" >
		<thead>
		<tr style="background-color:#86e27b; ">
			<th>Data</th>
			<th>Nome Produto</th>
			<th>Quantidade</th>
			<th>Unidade</th>
			<th>Motivo</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr class="linha">
			<td><?php echo date("d/m/Y", strtotime($row_produto['data']));?></td>
			<td><?php echo $row_produto['nome_produto']?></td>
			<td><?php echo $row_produto['quantidade']?></td>
			<td><?php echo $row_produto['unidade']?></td>
			<td><?php echo $row_produto['motivo']?></td>
		</tr>
		<?php
	}
	?>
		
	</tbody>
	</table>
	</div>

		
	</div>
<?php
	$objBd = new bd();
	$query="SELECT p.nome_produto,p.unidade,sum(pp.quantidade) AS quantidade ,pp.motivo FROM perda_produtos pp INNER JOIN produtos p on pp.produtos_id=p.id INNER JOIN estoques e on pp.estoques_id=e.id WHERE e.proprietarios_id=?  group by p.nome_produto,pp.motivo order by p.nome_produto";
	$param=array( );
	$param[0]=$_SESSION['id'];
	$type="s";
	$result2=$objBd->exec($query,$type,$param);
	?>
	<div class="table-responsive" >
	<table class="table table-striped table-hover table-condensed">
		<thead>
		<tr style="background-color:#86e27b; ">
			<th>Nome Produto</th>
			<th>Quantidade</th>
			<th>Unidade</th>
			<th>Motivo</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result2)){
		?>
		<tr class="linha">
			<td><?php echo $row_produto['nome_produto']?></td>
			<td><?php echo $row_produto['quantidade']?></td>
			<td><?php echo $row_produto['unidade']?></td>
			<td><?php echo $row_produto['motivo'];?></td>
		</tr>
		<?php
	}
	?>

	</tbody>
	</table>
	</div>


</div>
</body>
</html>

