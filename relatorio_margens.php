<!DOCTYPE html>
<html>
<head>
	<title>Relatorio de Vendas</title>
	<?php require_once("head.php")  ?>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<div>
	<?php require_once("menu.php"); 
	session_start();
	require_once 'bd.class.php';
	require_once 'funcoes.php';
		?>	
</div>


<div class="table-responsive" >
	<table class="highchart " data-graph-container-before="1" data-graph-type="line" style="display: none; ">
		<thead>
		<tr >
			<th>Data</th>
			<th>Receitas</th>
			<th>Despesas</th>
			<th>Liquido</th>
		</tr>	
	</thead>
	<tbody>
	<?php
	$objBd = new bd();
	$query='SELECT round((receitas.valor_res-despesas.valor_des) ,2)as valorlq,round(despesas.valor_des,2) as despesa,round(receitas.valor_res,2) as receita, concat(receitas.mes ,\'/\',receitas.ano) as datas FROM( SELECT sum(d.quantidade*d.valor) as valor_des,month( d.data )as mes ,year(d.data) ano FROM despesas d WHERE d.proprietarios_id=? GROUP BY ano, mes ) as despesas INNER JOIN ( SELECT sum(v.total) as valor_res,month( v.data )as mes ,year(v.data) ano FROM vendas v WHERE v.proprietarios_id=? GROUP BY ano, mes ) as receitas ON receitas.ano=despesas.ano and receitas.mes=despesas.mes';
	$param=array( );
	$param[0]=$_SESSION['id'];
	$param[1]=$_SESSION['id'];
	$type="ss";
	$result=$objBd->exec($query,$type,$param);
	while($row_produto = mysqli_fetch_assoc($result)){
		?>
		<tr>
			<td><?php echo $row_produto['datas'];?></td>
			<td><?php echo $row_produto['receita']?></td>
			<td><?php echo $row_produto['despesa']?></td>
			<td><?php echo $row_produto['valorlq']?></td>
			
		</tr>
		<?php
	}
	?>
		
	</tbody>
	</table>
</div>
</body>
</html>

