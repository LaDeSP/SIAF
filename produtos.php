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

	$sql = " SELECT * FROM produtos WHERE proprietarios_id = $id ORDER BY nome_produto ASC "; 

	$resultado = mysqli_query($link, $sql);

	$total_produtos = mysqli_num_rows($resultado);
	$quantidade_pg = 10;
	$num_pg = ceil($total_produtos/$quantidade_pg);
	$inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

	$result_produtos = " SELECT * FROM produtos WHERE proprietarios_id = $id ORDER BY nome_produto ASC LIMIT $inicio, $quantidade_pg  ";
	$resultado_produtos = mysqli_query($link, $result_produtos);
	$total_produtos = mysqli_num_rows($resultado_produtos);
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Produtos</title>
		<link rel="icon" href="imagens/favicon.png">
		
		<!-- jquery - link cdn -->
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<script src="lib/sweetalert/sweetalert.min.js"></script>
		<link rel="stylesheet" type="text/css" href="lib/sweetalert/sweetalert.css">
	
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
	    		<h1>Produtos</h1>
	    	</div>

	    	<div class="pull-right">
	    		<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#myModalcad">
	    		Cadastrar
	    		</button>

			<div class="modal fade" id="myModalcad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Cadastrar - Produto</h4>
						</div>
						<div class="modal-body">

							<form method="POST" action="produtos.php" enctype="multipart/form-data" id="formEditarCad">

								<div class="form-group">
									<label for="nome" class="control-label">Nome *</label>
									<input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Mandioca" required="requiored">
								</div>

								<div class="form-group">
									<label for="unidade" class="control-label">Unidade *</label><br />
									<select name="unidade" id="unidade" required="requiored">
										<option value="">Selecione...</option>
										<option value="KG">KG</option>
										<option value="LT">LT</option>
										<option  value="UN">UN</option>
										<option value="DZ">DZ</option>
									</select>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
									<button type="submit" class="btn btn-success" name="salvar">Cadastrar</button>
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
						<th>Unidade</th>
						<th>Ações</th>
					</tr>
				</thead>

				<tbody>
				<?php while($produtos = mysqli_fetch_assoc($resultado_produtos)){ ?>
					<tr>
						<td><?php echo $produtos['id']; ?></td>
						<td><?php echo $produtos['nome_produto']; ?></td>
						<td><?php echo $produtos['unidade']; ?></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal" data-codproduto="<?php echo $produtos['id']; ?>" data-nome="<?php echo $produtos['nome_produto']; ?>"
						data-unidade="<?php echo $produtos['unidade']; ?>">
						Editar
						</button>
						<a href="javascript: if(confirm ('Tem certeza que deseja excluir este produto?')) location.href='produtos_excluir.php?prod=<?php echo $produtos['id']?>';" class="btn btn-xs btn-danger"">
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
					      <a href="produtos.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
					        <span aria-hidden="true">&laquo;</span>
					      </a>
					<?php }else{ ?>
							<span aria-hidden="true">&laquo;</span>
				    <?php } ?>
				    </li>

				    <?php
				    	for($i = 1;  $i < $num_pg + 1; $i++){ ?>
				    		<li><a href="produtos.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
				    <?php } ?>

				    <li>
				    <?php 
				    	if($pagina_posterior <= $num_pg){ ?>
					      <a href="produtos.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
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
		        <form method="POST" action="produtos.php" id="formEditarCad">
		          <div class="form-group">
		            <label for="produto-name" class="control-label">Nome:</label>
		            <input name="nome" type="text" class="form-control" id="produto-name" required="requiored">
		          </div>

				  <div class="form-group">
					<label for="unidade" class="control-label">Unidade *</label><br />
					<select name="unidade" id="unidade" required="requiored">
						<option>Selecione...</option>
						<option value="KG">KG</option>
						<option value="LT">LT</option>
						<option  value="UN">UN</option>
						<option value="DZ">DZ</option>
					</select>
				   </div>

		          <input name="id" type="hidden" id="cod-produto">
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button name="editar" type="submit" class="btn btn-success">Alterar</button>
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
				var recipientnome = button.data('nome') // Extract info from data-* attributes
				var recipientcod = button.data('codproduto')
				var recipientunidade = button.data('unidade')
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Editar - ' + recipientnome)
			 	modal.find('#cod-produto').val(recipientcod)
			 	modal.find('#produto-name').val(recipientnome)
			 	modal.find('#unidade-name').val(recipientunidade)
			})
		</script>

		<?php 
			function registraProduto(){
				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$nome =$_POST['nome'];
				$unidade = $_POST['unidade'];

				$email = $_SESSION['email'];
				$select = "select id from proprietarios where email = '$email'";
				$resultado = mysqli_query($link, $select);

				if($resultado){
					$user_id = array();

					$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
					$user_id = $row;
				}

				$id = $user_id['id'];

				$sql = " insert into produtos(nome_produto, unidade, proprietarios_id) values ('$nome', '$unidade', '$id') ";

				//executar a query
				mysqli_query($link, $sql);

				if($sql){
		            echo "
		            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=produtos.php'>
		            <script type=\"text/javascript\">
		              alert(\"Produto registrado!\");
		            </script>
		            ";
				}
				else{
					echo "
		            <META HTTP-EQUIV=REFRESH CONTENT = '0;URL=produtos.php'>
		            <script type=\"text/javascript\">
		              alert(\"Não foi possível registrar o produto!\");
		            </script>
		            ";
				}
			}

			if(isset($_POST['salvar'])){
					registraProduto();
			}

			function editarProduto(){
				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$cod = $_POST['id'];
				$nome = $_POST['nome'];
				$unidade = $_POST['unidade'];

				$sql = " UPDATE produtos SET nome_produto = '$nome', unidade = '$unidade' WHERE id = '$cod' ";

				$resultado = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) != 0){
						echo "
							<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=produtos.php'>
							<script type=\"text/javascript\">
								alert(\"Produto alterado com sucesso!\");
							</script>
							";
						}else{
						echo "
							<META HTTP-EQUI=REFRESH CONTENT = '0;URL=produtos.php'>
							<script type=\"text/javascript\">
								alert(\"Produto não pode ser alterado!\");
							</script>
						";
					}
			}

			if(isset($_POST['editar'])){
				editarProduto();
			}
		?>

	</body>
</html>