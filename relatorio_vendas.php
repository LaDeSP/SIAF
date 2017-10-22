<!DOCTYPE html>
<html>
<head>
	<title>Relatorio de Vendas</title>
	<?php require_once("head.php")  ?>
	
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
	$query='SELECT v.id,v.data,p.nome_produto ,v.quantidade,p.unidade,v.preco,v.total FROM vendas v INNER JOIN produtos p on p.proprietarios_id=v.proprietarios_id and p.id=v.produtos_id  WHERE v.proprietarios_id=? ORDER BY v.data';
	$param=array( );
	$param[0]=$_SESSION['id'];
	$type="s";
	$result=$objBd->exec($query,$type,$param);
	?>
	<div class="table-responsive" >
	<table class=" table table-striped table-hover table-condensed" >
		<thead>
		<tr style="background-color:#86e27b; ">
			<th>ID</th>
			<th>Data</th>
			<th>Nome Produto</th>
			<th>Quantidade</th>
			<th>Unidade</th>
			<th>Valor unitário</th>
			<th>Valor Total</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr>
			<td><?php echo $row_produto['id']?></td>
			<td><?php echo date("d/m/Y", strtotime($row_produto['data']));?></td>
			<td><?php echo $row_produto['nome_produto']?></td>
			<td><?php echo $row_produto['quantidade']?></td>
			<td><?php echo $row_produto['unidade']?></td>
			<td><?php echo formata_moeda($row_produto['preco']);?></td>
			<td><?php echo formata_moeda($row_produto['total']);?></td>
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
	$query="SELECT p.nome_produto ,sum(v.quantidade) as quantidade ,p.unidade,sum(v.total) as total FROM vendas v INNER JOIN produtos p on p.proprietarios_id=v.proprietarios_id and p.id=v.produtos_id WHERE v.proprietarios_id=? GROUP BY p.nome_produto,p.unidade 
		union
		SELECT '' as nome_produto ,'' as quantidade ,'Valor total de vendas:' as unidade,sum(v.total) as total FROM vendas v INNER JOIN produtos p on p.proprietarios_id=v.proprietarios_id and p.id=v.produtos_id WHERE v.proprietarios_id=? ;";
	$param=array( );
	$param[0]=$_SESSION['id'];
	$param[1]=$_SESSION['id'];
	$type="ss";
	$result2=$objBd->exec($query,$type,$param);
	?>
	<div class="table-responsive" >
	<table class="table table-striped table-hover table-condensed">
		<thead>
		<tr style="background-color:#86e27b; ">
			<th>Nome Produto</th>
			<th>Quantidade</th>
			<th>Unidade</th>
			<th>Total</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result2)){
		?>
		<tr>
			<td><?php echo $row_produto['nome_produto']?></td>
			<td><?php echo $row_produto['quantidade']?></td>
			<td><?php echo $row_produto['unidade']?></td>
			<td><?php echo formata_moeda($row_produto['total']);?></td>
		</tr>
		<?php
	}
	?>

	</tbody>
	</table>
	</div>

<div class="table-responsive" >
	<table class="highchart " data-graph-container-before="1" data-graph-type="column" style="display: none; ">
		<thead>
		<tr >
			<th>Data</th>
			<th>Quantidade</th>
			<th>Valor Vendas</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	$query='SELECT v.data,SUM(v.quantidade) as quantidade,SUM(v.total) as total FROM vendas v WHERE v.proprietarios_id=? GROUP BY v.data';
	$param=array( );
	$param[0]=$_SESSION['id'];
	$type="s";
	$result=$objBd->exec($query,$type,$param);
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr>
			<td><?php echo date("d/m/Y", strtotime($row_produto['data']));?></td>
			<td><?php echo $row_produto['quantidade']?></td>
			<td><?php echo $row_produto['total']?></td>
		</tr>
		<?php
	}
	?>
		
	</tbody>
	</table>
</div>
</body>
</html>

