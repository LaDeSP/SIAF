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
	$query='SELECT i.nome_investimento,i.descricao,i.valor,i.data FROM investimentos i WHERE i.proprietarios_id=? ORDER BY i.data';
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
			<th>Nome Investimento</th>
			<th>Descrição</th>
			<th>Valor</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr class="linha">
			<td><?php echo date("d/m/Y", strtotime($row_produto['data']));?></td>
			<td><?php echo $row_produto['nome_investimento']?></td>
			<td><?php echo $row_produto['descricao']?></td>
			<td><?php echo formata_moeda($row_produto['valor']);?></td>
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
	$query="SELECT i.nome_investimento,i.valor FROM investimentos i WHERE i.proprietarios_id=? GROUP BY nome_investimento
		union
		SELECT 'Valor total de investimentos' as nome_investimento ,SUM(i.valor) as valor FROM investimentos i WHERE i.proprietarios_id=?";
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
			<th>Nome Investimento</th>
			<th>Total</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	while($row_produto = mysqli_fetch_assoc($result2)){
		?>
		<tr class="linha">
			<td><?php echo $row_produto['nome_investimento']?></td>
			<td><?php echo formata_moeda($row_produto['valor']);?></td>
		</tr>
		<?php
	}
	?>

	</tbody>
	</table>
	</div>

<div class="table-responsive" >
	<table class="highchart " data-graph-container-before="1" data-graph-type="line" style="display: none; ">
		<thead>
		<tr >
			<th>Data</th>
			<th>Valor investimento</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	$query='SELECT i.data,i.valor FROM investimentos i WHERE i.proprietarios_id=?';
	$param=array( );
	$param[0]=$_SESSION['id'];
	$type="s";
	$result=$objBd->exec($query,$type,$param);
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr>
			<td><?php echo date("d/m/Y", strtotime($row_produto['data']));?></td>
			<td><?php echo $row_produto['valor']?></td>
		</tr>
		<?php
	}
	?>
		
	</tbody>
	</table>
</div>
</body>
</html>

