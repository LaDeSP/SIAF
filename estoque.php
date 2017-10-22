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

	$sql = " SELECT  estoques.produtos_id,estoques.id, nome_produto,estoques.quantidade, unidade FROM estoques inner JOIN produtos on produtos_id = produtos.id WHERE estoques.proprietarios_id = $id and estoques.quantidade > 0 ORDER BY produtos.nome_produto ";
	 	
	$resultado = mysqli_query($link, $sql);

   	$total_estoques = mysqli_num_rows($resultado);
  	$quantidade_pg = 10;
  	$num_pg = ceil($total_estoques/$quantidade_pg);
  	$inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

  	$result_estoques = " SELECT  estoques.produtos_id,estoques.id, nome_produto,estoques.quantidade, unidade FROM estoques inner JOIN produtos on produtos_id = produtos.id WHERE estoques.proprietarios_id = 6 and estoques.quantidade > 0 ORDER BY produtos.nome_produto  LIMIT $inicio, $quantidade_pg";

   	$resultado_estoques = mysqli_query($link, $result_estoques);
  	$total_estoques = mysqli_num_rows($resultado_estoques);
?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">

		<title>Estoque</title>
		<link rel="icon" href="imagens/favicon.png">

		<!-- jquery - link cdn -->
		<script src="js/JQuery/jquery-2.2.4.min.js"></script>

		<!-- bootstrap - link cdn -->
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link href="estilos.css" rel="stylesheet">

		<link href="bootstrap/css/bootstrap-datepicker.css" rel="stylesheet">
		<script src="bootstrap/js/bootstrap-datepicker.min.js"></script>
		<script src="bootstrap/js/bootstrap-datepicker.pt-BR.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>

		<?php
		require_once("menu.php");
		?>


	    <div class="container">
	    	<div class="page-header espaco">
	    		<h1>Estoque</h1>
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
							<h4 class="modal-title" id="myModalLabel">Registrar - Estoque</h4>
						</div>
						<div class="modal-body">

							<form method="POST" action="estoque.php" enctype="multipart/form-data" id="formEditarCad">

								<div class="form-group">

									<label for="select_produto" class="control-label">Produto *</label>
									<br />
									<select name="select_produto">
									<option>Selecione...</option>
									<?php
										$result_produto = " SELECT * FROM produtos WHERE proprietarios_id = $id ORDER BY nome_produto ASC";
										$resultado_produto = mysqli_query($link, $result_produto);
										while($row_produto = mysqli_fetch_assoc($resultado_produto)){ ?>
											<option value="<?php echo $row_produto['id']; ?>">
											<?php echo $row_produto['nome_produto']; ?> </option>
										<?php
										}
										?>
									</select>
								</div>

									<div class="form-group">
										<label for="quantidade" class="control-label">Quantidade *</label>
										<input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" required="requiored">
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
						<th>Unidade</th>
						<th>Ações</th>
					</tr>
				</thead>
				</thead>

				<tbody>
				<?php while($estoque = mysqli_fetch_assoc($resultado_estoques)){
						if($estoque['quantidade'] > 0) {?>
					<tr>
						<td><?php echo $estoque['id']; ?></td>
						<td><?php echo $estoque['nome_produto']; ?></td>
						<td><?php echo $estoque['quantidade']; ?></td>
						<td><?php echo $estoque['unidade']; ?></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"
								data-codestoque="<?php echo $estoque['id']; ?>"
								data-codproduto="<?php echo $estoque['nome_produto']; ?>"
								data-quantidade="<?php echo $estoque['quantidade']; ?>">
								Editar
						</button>
						
						<a href="javascript: if(confirm ('Tem certeza que deseja excluir esse produto do estoque?')) location.href='estoque_excluir.php?estoq=<?php echo $estoque['id']?>';" class="btn btn-xs btn-danger"">
						Excluir
						</a>
						<button type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#exampleModal2"
								data-codestoque="<?php echo $estoque['id']; ?>"
								data-produtosid="<?php echo $estoque['produtos_id']; ?>"
								>

								Perda
						</button>
						</td>
					</tr>
				<?php }} ?>
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
		                <a href="estoque.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
		                  <span aria-hidden="true">&laquo;</span>
		                </a>
		          	<?php }else{ ?>
		              <span aria-hidden="true">&laquo;</span>
		            <?php } ?>
		            </li>

		            <?php
		              for($i = 1;  $i < $num_pg + 1; $i++){ ?>
		                <li><a href="estoque.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		            <?php } ?>

		            <li>
		            <?php
		              if($pagina_posterior <= $num_pg){ ?>
		                <a href="estoque.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
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
		        <form method="POST" action="estoque.php">

		          <div class="form-group">
		            <label for="codproduto-name" class="control-label">Produto *</label>
		            <input name="codproduto" type="text" class="form-control" id="codproduto-name" required="requiored">
		          </div>

		          <div class="row">
					  <div class="form-group col-md-8">
					  	<label for="quantidade-name" class="control-label">Quantidade *</label>
						<input name="quantidade" type="text" class="form-control" id="quantidade-name" required="requiored">
					  </div>
				  </div>

		          <input name="id" type="hidden" id="cod-estoque">

			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="submit" class="btn btn-primary" name="editar">Alterar</button>
			      </div>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>

		<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="exampleModalLabel">Registrar Perda</h4>
		      </div>
		      <div class="modal-body">
		        <form method="POST" action="estoque.php">

				  <div class="form-group">
				  	<label for="quantidade-name" class="control-label">Quantidade perdida *</label>
					<input name="quantidade" type="text" class="form-control" id="quantidade-name" required="requiored">
				  </div>

				  <div class="row">
						<div class="form-group col-md-8">
						  <label for="motivo" class="control-label">Motivo *</label>
						  <br />
						  	<select name="motivo" id="motivo">
						  		<option value="">Selecione...</option>
								<option value="Estragou">Estragou</option>
								<option value="Consumo próprio">Consumo próprio</option>
							</select>
						</div>

						<div class="input-group date col-md-3">
							<label for="data" class="control-label">Data *</label>
							<input type="date" class="form-control" id="data" name="data" required="requiored"><br />
						</div>

						<input type="hidden" id="id_estoque_ed" name="id_estoque" value="">
						<input type="hidden" id="id_produto_ed" name="id_produto" value="">

						<div class="col-md-1"><br /></div>
				  </div>

			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
			        <button type="submit" class="btn btn-primary" name="perda">Registrar</button>
			      </div>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>

		<script src="bootstrap/js/bootstrap.min.js"></script>

		<script type="text/javascript">
			$('#exampleModal').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipientcodproduto = button.data('codproduto') // Extract info from data-* attributes
				var recipientcod = button.data('codestoque')
				var recipientquantidade = button.data('quantidade')

			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Editar - Estoque #' + recipientcod)
			 	modal.find('#cod-estoque').val(recipientcod)
			 	modal.find('#codproduto-name').val(recipientcodproduto)
			 	modal.find('#quantidade-name').val(recipientquantidade)
			});
			$('#exampleModal2').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var recipientcod = button.data('codestoque')
				var recipientcodproduto = button.data('produtosid') 
			  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
			  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
				var modal = $(this)
			 	modal.find('.modal-title').text('Perda - Estoque #' + recipientcod)
			 	modal.find('#id_estoque_ed').val(recipientcod)
			 	modal.find('#id_produto_ed').val(recipientcodproduto)
			});

		</script>

		<?php
			function registraEstoque(){
				$produto = $_POST['select_produto'];
				$quant = $_POST['quantidade'];

		        $objBd = new bd();
		        $link = $objBd->conecta_mysql();

		        $email = $_SESSION['email'];
		        $select = "select proprietarios.id, produtos.nome_produto from proprietarios, produtos where email = '$email'";
		        $resultado = mysqli_query($link, $select);

		          if($resultado){
		            $user_id = array();

		            $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
		            $user_id = $row;
		          }

		        $id = $user_id['id'];

		        if($user_id['nome_produto'] != $produto){
		        	$sql = " CALL estoque ('$quant',$id, '$produto')";

		        	mysqli_query($link, $sql);
		        }else{
		        	$sql = " UPDATE estoques, produtos SET estoques.quantidade = estoques.quantidade + $quant WHERE estoques.produtos_id = produtos.id";

		        	mysqli_query($link, $sql);
		        }


		        if($sql){
		        	echo "
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Produto(s) registrado(s) no estoque!\");
		        		</script>
		        	";
		        }else{
		        	echo"
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Não foi possível registrar produto(s) no estoque!\");
		        		</script>
		        	";
		        }
			}

			if(isset($_POST['salvar'])){
				registraEstoque();
			}

			function editarEstoque(){
				$cod = $_POST['id'];
				$quantidade = $_POST['quantidade'];

				$objBd = new bd();
				$link = $objBd->conecta_mysql();

				$sql = " UPDATE estoques SET  quantidade = '$quantidade'
				WHERE id = '$cod' ";

				$resultado = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) != 0){
					echo "
					<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php'>
					<script type=\"text/javascript\">
						alert(\"Estoque alterado com sucesso!\");
					</script>
					";
				}else{
					echo "
						<META HTTP-EQUI=REFRESH CONTENT = '0;URL=estoque.php'>
						<script type=\"text/javascript\">
							alert(\"Estoque não pode ser alterado!\");
						</script>
					";
				}

			}

			if(isset($_POST['editar'])){
				editarEstoque();
			}

			function registraPerda($perda){
				$motivo = $_POST['motivo'];
				$quantidade = $_POST['quantidade'];
				$perda = $_POST['id_estoque'];
				$produto = $_POST['id_produto'];
				$data = str_replace("/", "-", $_POST["data"]);
			    $data1 = date('Y-m-d', strtotime($data));


		        $objBd = new bd();
		        $link = $objBd->conecta_mysql();

		   		$sql = "CALL perdas('$quantidade', '$motivo', '$data1', '$perda','$produto'); ";

		       $resultado =  mysqli_query($link, $sql);

		        if(mysqli_num_rows($resultado)){
		        	echo "
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Perda registrada!\");
		        		</script>
		        	";
		        }else{
		        	echo"
		        		<META HTTP-EQUIV=REFRESH CONTENT = '0;URL=estoque.php'>
		        		<script type=\"text/javascript\">
		        			alert(\"Não foi possível registrar perda!\");
		        		</script>
		        	";
		        }


			}

			if(isset($_POST['perda'])){
				registraPerda($_POST['perda']);
			}
		?>

	</body>
</html>
