<?php
	
	set_time_limit(0);
	
	require_once('bd.class.php');
	require_once('funcoes.php');
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
		<title>Vendas</title>
		<?php require_once("head.php")  ?>
	</head>

	<body>

		<?php
		require_once("menu.php");
		?>


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
										$result_produto = " SELECT produtos.id, nome_produto FROM produtos INNER JOIN estoques on produtos_id = produtos.id WHERE estoques.proprietarios_id = $id and estoques.quantidade>0 GROUP BY produtos.id, nome_produto ORDER BY nome_produto ASC";
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
										<input type="text" class="form-control ValoresItens" data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," id="preco" name="preco" placeholder="Preço R$" required="requiored">
									</div>

									<div class="form-group col-md-4">
										<label for="quantidade" class="control-label">Quantidade *</label>
									   	<input type="text" class="form-control" id="quantidade" name="quantidade" placeholder="Quantidade" required="requiored">
									</div>
								</div>

								<div class="input-group date">
										<label for="data" class="control-label">Data *</label>
									   	<input type="text" class="form-control data" id="data" name="data" required="requiored">
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
					<tr >
						<th>Código</th>
						<th>Produto</th>
						<th>Quantidade</th>
						<th>Preço Unitario (R$)</th>
						<th>Total (R$)</th>
						<th>Data</th>
						<th>Ações</th>
					</tr>
				</thead>
				</thead>

				<tbody>
				<?php while($venda = mysqli_fetch_assoc($resultado_vendas)){ ?>
					<tr class="linha">
						<td><?php echo $venda['id']; ?></td>
						<td><?php echo $venda['nome_produto']; ?></td>
						<td><?php echo $venda['quantidade']; ?></td>
						<td><?php echo formata_moeda($venda['preco']); ?></td>
						<td><?php echo formata_moeda($venda['total']); ?></td>
						<td><?php echo date("d/m/Y", strtotime($venda['data'])); ?></td>
						<td>
						<button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"
								data-codestoque="<?php echo $venda['id']; ?>"
								data-nome="<?php echo $venda['nome_produto']; ?>"
								data-preco="<?php echo formata_moeda($venda['preco']); ?>"
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
						<input name="preco" type="text" class="form-control ValoresItens" data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," id="preco-name" required="requiored">
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

		<script src="bootstrap/js/bootstrap.min.js"></script>

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
						$preco=moeda_clean($preco);
				$sql = " CALL vendas ('$data1','$quantidade','$preco','$id','$codproduto') ";

				$result=mysqli_query($link, $sql);

		        if(mysqli_num_rows($result)){

		        	echo "
		        		<META HTTP-EQUIV=REFRESH CONTENT = '3;URL=vendas.php'>
		        		<script type=\"text/javascript\">
              
			             $(window).load(function() {
			                 modal({
			                 type: 'success',
			                 title: 'Sucesso',
			                 text: 'Venda registrada!',
			                 autoclose: false,
			                 size: 'large',
			                 center: false,
			                 theme: 'atlant',
			                });
			              });
			            </script>
		        	";
		        }else{
		        	echo"
		        		<META HTTP-EQUIV=REFRESH CONTENT = '3;URL=vendas.php'>
		        		 <script type=\"text/javascript\">
		              $(window).load(function() {
		                 modal({
		                 type: 'error',
		                 title: 'Erro',
		                 text: 'Não foi possível registrar a venda!',
		                 autoclose: false,
		                 size: 'large',
		                 center: false,
		                 theme: 'atlant',
		                });
		              });
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
				$preco=moeda_clean($preco);
				$sql = "CALL vendas_edt('$data1','$quantidade','$preco','$cod');";

				$resultado = mysqli_query($link, $sql);

				if(mysqli_affected_rows($link) != 0){
					echo "
						<META HTTP-EQUIV=REFRESH CONTENT = '3;URL=vendas.php'>
						<script type=\"text/javascript\">

			             $(window).load(function() {
			                 modal({
			                 type: 'success',
			                 title: 'Sucesso',
			                 text: 'Venda alterada com sucesso!',
			                 autoclose: false,
			                 size: 'large',
			                 center: false,
			                 theme: 'atlant',
			                });
			              });

        
            			</script>
						";
				}else{
					echo "
						<META HTTP-EQUI=REFRESH CONTENT = '3;URL=vendas.php'>
						<script type=\"text/javascript\">
			              $(window).load(function() {
			                 modal({
			                 type: 'error',
			                 title: 'Error',
			                 text: 'Venda não pode ser alterada!',
			                 autoclose: true,
			                 size: 'large',
			                 center: false,
			                 theme: 'atlant',
			                });
			              });
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
