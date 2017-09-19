<?php

	require_once('bd.class.php');
	session_start();

	if(!isset($_SESSION['email'])){
		header('Location: index.php');
	}

	$objBd = new bd();
	$link = $objBd->conecta_mysql();

	$email = $_SESSION['email'];
	$select = "select id from proprietarios where email = '$email'";

	$result = mysqli_query($link, $select);

	if($result){
		$user_id = array();

		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$user_id = $row;
	}

	$id = $user_id['id'];

	$pagina = (isset($_GET['pagina'])) ? $_GET['pagina'] : 1;

	$sql = " SELECT vendas.id, nome_produto, quantidade, preco, total, data FROM vendas, produtos WHERE produtos_id = produtos.id AND vendas.proprietarios_id = $id  ORDER BY data DESC ";

	$resultado = mysqli_query($link, $sql);

   	$total_vendas = mysqli_num_rows($resultado);
  	$quantidade_pg = 10;
  	$num_pg = ceil($total_vendas/$quantidade_pg);
  	$inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

  	$result_vendas = " SELECT vendas.id, nome_produto, quantidade, preco, total, data FROM vendas, produtos WHERE produtos_id = produtos.id AND vendas.proprietarios_id = $id  ORDER BY data DESC LIMIT $inicio, $quantidade_pg";
  	$resultado_vendas = mysqli_query($link, $result_vendas);
  	$total_vendas = mysqli_num_rows($resultado_vendas);
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Vendas</title>
		<link rel="icon" href="imagens/favicon.png">

		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="js/funcoes.js"> </script>
		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<link href="bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap-datepicker.min.js"></script>
		<script src="bootstrap/js/bootstrap-datepicker.pt-BR.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<!-- Static navbar -->
	    <nav class="navbar navbar-default navbar-static-top navbar-fixed-top">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <!--<img src="imagens/logo.png" />-->
	          <a href="home.php" class="navbar-brand">
	          <span class="img-logo">Logo</span>
	          </a>
	        </div>

	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li><a href="home.php">Início</a></li>
	            <li><a href="despesas.php">Despesas</a></li>
	            <li><a href="investimentos.php">Investimentos</a></li>
	            <li><a href="vendas.php">Vendas</a></li>
	            <li><a href="estoque.php">Estoque</a></li>
	            <li><a href="produtos.php">Produtos</a></li>
	           	<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
	            	Relatórios <b class="caret"></b></a>
					  <ul class="dropdown-menu">
					    <li><a href="#">Relatório de Despesas</a></li>
					    <li><a href="#">Relatório de Investimentos</a></li>
					    <li><a href="relatorio_vendas.php">Relatório de Vendas</a></li>
					    <li><a href="#">Relatório de Perda de Produtos</a></li>
					    <li><a href="#">Margens</a></li>
					  </ul>
	            </li>
	            <li class="divisor" role="separator"></li>

	            <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i>
	            	Usuário <b class="caret"></b></a>
					  <ul class="dropdown-menu">
					    <li><a href="exibir_cadastro.php">Meu Cadastro</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="sair.php">Sair</a></li>
					  </ul>
	            </li>
	          </ul>
	        </div><!--/.nav-collapse -->
	      </div>
	    </nav>


	    <div class="container">
	    	<div class="page-header espaco">
	    		<h1>Vendas</h1>
	    	</div>

	    	<div class="pull-right">
	    		<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalcad">
	    		Registrar
	    		</button>

			<div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Registrar - Venda</h4>
						</div>
						<div class="modal-body">

							<form method="POST" action="vendas.php" enctype="multipart/form-data" id="formEditarCad">


								<div class="form-group">
									<label for="select_produto" class="control-label">Produto *</label>
									<br />
									<select name="select_produto">
									<option>Selecione...</option>
									<?php
										$result_produto = " SELECT produtos.id, nome_produto FROM produtos, estoques WHERE estoques.proprietarios_id = $id AND produtos_id = produtos.id ORDER BY nome_produto ASC ";
										$resultado_produto = mysqli_query($link, $result_produto);
										while($row_produto = mysqli_fetch_assoc($resultado_produto)){ ?>
											<option value="<?php echo $row_produto['id']; ?>">
											<?php echo $row_produto['nome_produto']; ?> </option>
										<?php
										}
										?>
									</select>
								</div>

								<div class="row">
									<div class="form-group col-md-8">
										<label for="preco" class="control-label">Preço (R$) *</label>
										<input type="text" class="form-control" id="preco" name="preco" placeholder="Preço R$" required="requiored">
									</div>

									<div class="form-group col-md-4">
										<label for="quantidade" class="control-label">Quantidade *</label>
									   	<input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" required="requiored">
									</div>
								</div>

								<div class="input-group date">
										<label for="data" class="control-label">Data *</label>
									   	<input type="date" class="form-control" id="data" name="data" required="requiored">
								</div>

								<br />

								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-success" name="salvar">Registrar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>

	    	</div>
	    	<br />


			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr>
						<th>Código</th>
						<th>Produto</th>
						<th>Quantidade</th>
						<th>Preço (R$)</th>
						<th>Total (R$)</th>
						<th>Data</th>
						<th>Ações</th>
					</tr>
				</thead>
				</thead>

				<tbody>
				<?php while($venda = mysqli_fetch_assoc($resultado_vendas)){ ?>
					<tr>
						<td><?php echo $venda['id']; ?></td>
						<td><?php echo $venda['nome_produto']; ?></td>
						<td><?php echo $venda['quantidade']; ?></td>
						<td><?php echo $venda['preco']; ?></td>
						<td><?php echo $venda['total']; ?></td>
						<td><?php echo date("d/m/Y", strtotime($venda['data'])); ?></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"
								data-codestoque="<?php echo $venda['id']; ?>"
								data-nome="<?php echo $venda['nome_produto']; ?>"
								data-preco="<?php echo $venda['preco']; ?>"
								data-quantidade="<?php echo $venda['quantidade']; ?>"
								data-data="<?php echo $venda['data']; ?>">
								Editar
						</button>
						<a href="javascript: if(confirm ('Tem certeza que deseja excluir essa venda?')) location.href='vendas_excluir.php?venda=<?php echo $venda['id']?>';" class="btn btn-xs btn-danger"">
						Excluir
						</a>
						</td>
					</tr>
				<?php } ?>
				</tbody>

			</table>


			<div class="clearfix"></div>

			<div class="col-md-4"></div>
			<div class="col-md-4">
		        <?php
		          $pagina_anterior = $pagina - 1;
		          $pagina_posterior = $pagina + 1;
		        ?>
		        <nav aria-label="Page navigation">
		          <ul class="pagination">
		            <li>
		            <?php
		              if($pagina_anterior != 0){ ?>
		                <a href="vendas.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
		                  <span aria-hidden="true">&laquo;</span>
		                </a>
		          	<?php }else{ ?>
		              <span aria-hidden="true">&laquo;</span>
		            <?php } ?>
		            </li>

		            <?php
		              for($i = 1;  $i < $num_pg + 1; $i++){ ?>
		                <li><a href="vendas.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		            <?php } ?>

		            <li>
		            <?php
		              if($pagina_posterior <= $num_pg){ ?>
		                <a href="vendas.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
		                  <span aria-hidden="true">&raquo;</span>
		                </a>
		          	<?php }else{ ?>
		              <span aria-hidden="true">&raquo;</span>
		            <?php } ?>
		            </li>

		          </ul>
		        </nav>
			</div>
			<div class="col-md-4"></div>

		</div>
	    </div>



		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Editar</h4>
		      </div>
		      <div class="modal-body">
		        <form method="POST" action="vendas.php">

		          <div class="form-group">
		            <label for="produto-name" class="control-label">Produto *</label>
		            <input name="codproduto" type="text" class="form-control" id="produto-name" required="requiored">
		          </div>

		          <div class="row">
					  <div class="form-group col-md-8">
					  	<label for="preco-name" class="control-label">Preço *R$) *</label>
						<input name="preco" type="text" class="form-control" id="preco-name" required="requiored">
					  </div>

					  <div class="form-group col-md-4">
					  	<label for="quantidade-name" class="control-label">Quantidade *</label>
						<input name="quantidade" type="text" class="form-control" id="quantidade-name" required="requiored">
					  </div>
				  </div>

				  <div class="input-group date">
				  	<label for="data-name" class="control-label">Data *</label>
					<input type="date" class="form-control" id="data-name" name="data" required="requiored">
				  </div>
				  <br />

		          <input name="id" type="hidden" id="cod-estoque">

			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="submit" class="btn btn-primary" name='editar'>Alterar</button>
			      </div>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$('#exampleModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipientcodproduto = button.data('nome') // Extract info from data-* attributes
				var recipientcod = button.data('codestoque')
				var recipientpreco = button.data('preco')
				var recipientquantidade = button.data('quantidade')
				var recipientdata = button.data('data')

			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Editar - Venda #' + recipientcod)
			 	modal.find('#cod-estoque').val(recipientcod)
			 	modal.find('#produto-name').val(recipientcodproduto)
			 	modal.find('#preco-name').val(recipientpreco)
			 	modal.find('#quantidade-name').val(recipientquantidade)
			 	modal.find('#data-name').val(recipientdata)
			})
		</script>

		<?php

			function registraVenda(){
				$codproduto = $_POST['select_produto'];

				$preco = $_POST['preco'];
				$quantidade = $_POST['quantidade'];

				$data = str_replace("/", "-", $_POST["data"]);
			    $data1 = date('Y-m-d', strtotime($data));

			    $objBd = new bd();
				$link = $objBd->conecta_mysql();

		        $email = $_SESSION['email'];
		        $select = "select id from proprietarios where email = '$email'";
		        $resultado = mysqli_query($link, $select);

		          if($resultado){
		            $user_id = array();

		            $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		            $user_id = $row;
		          }

		        $id = $user_id['id'];

				$sql = " INSERT INTO vendas(data, quantidade, preco, total, proprietarios_id, produtos_id) VALUES ('$data1', '$quantidade', '$preco', (quantidade * preco), '$id', '$codproduto') ";

				mysqli_query($link, $sql);

		        if($sql){
		        	$update = " UPDATE estoques, produtos, vendas SET estoques.quantidade = estoques.quantidade - '$quantidade' WHERE vendas.produtos_id = $codproduto AND vendas.produtos_id = produtos.id AND estoques.produtos_id = produtos.id";

		        	mysqli_query($link, $update);

		        	echo "
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Venda registrada!\");
		        		</script>
		        	";
		        }else{
		        	echo"
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Não foi possível registrar a venda!\");
		        		</script>
		        	";
		        }
			}

			if(isset($_POST['salvar'])){
				registraVenda();
			}

			function editaEstoque(){
				$cod = $_POST['id'];
				$preco = $_POST['preco'];
				$quantidade = $_POST['quantidade'];

				$data = str_replace("/", "-", $_POST["data"]);
			    $data1 = date('Y-m-d', strtotime($data));

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$sql = " UPDATE vendas SET  preco = '$preco', quantidade = '$quantidade', data = '$data1', total = (preco * quantidade) WHERE id = '$cod' ";

				$resultado = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) != 0){
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=vendas.php'>
						<script type=\"text/javascript\">
							alert(\"Venda alterada com sucesso!\");
						</script>
						";
				}else{
					echo "
						<META HTTP-EQUI=REFRESH CONTENT = '0;URL=vendas.php'>
						<script type=\"text/javascript\">
							alert(\"Venda não pode ser alterada!\");
						</script>
					";
				}
			}

			if(isset($_POST['editar'])){
				editaEstoque();
			}
		?>

	</body>
</html>
