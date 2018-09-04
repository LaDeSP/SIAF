<?php

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

  $sql = " SELECT id, nome_despesa, descricao, valor, quantidade, data  FROM despesas WHERE proprietarios_id = $id ORDER BY data ASC";

  $resultado = mysqli_query($link, $sql);

  $total_despesas = mysqli_num_rows($resultado);
  $quantidade_pg = 10;
  $num_pg = ceil($total_despesas/$quantidade_pg);
  $inicio = ($quantidade_pg*$pagina)-$quantidade_pg;

  $result_despesas = " SELECT id, nome_despesa, descricao, valor, quantidade, data FROM despesas WHERE proprietarios_id = $id ORDER BY data LIMIT $inicio, $quantidade_pg ";
  $resultado_despesas = mysqli_query($link, $result_despesas);
  $total_despesas = mysqli_num_rows($resultado_despesas);
?>

<!DOCTYPE HTML>
<html lang="pt-br">
  <head>


<?php require_once("head.php")  ?>
<title>Despesas</title>

  </head>

  <body>

    <?php require_once("menu.php");	?>


      <div class="container">
        <div class="page-header espaco">
          <h1>Despesas</h1>
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
              <h4 class="modal-title" id="myModalLabel">Registrar - Despesa</h4>
            </div>
            <div class="modal-body">

              <form method="POST" action="despesas.php" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="nome" class="control-label">Nome *</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Ex: Conta de luz" required="requiored">
                </div>

                <div class="form-group">
                  <label for="descricao" class="control-label">Descrição </label>
                  <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição"></textarea>
                </div>

                <div class="row">
                  <div class="form-group col-md-8">
                    <label for="valor" class="control-label">Valor *</label>
                    <input type="text" autofocus class="form-control ValoresItens" data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," id="valor-name" name="valor" placeholder="Valor R$" required="requiored">
                  </div>

                  <div class="form-group col-md-4">
                    <label for="quantidade" class="control-label">Quantidade *</label>
                    <input type="text" class="form-control" id="quant" name="quant" placeholder="Quantidade" required="requiored">
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
          <tr>
            <th>Código</th>
            <th>Despesa</th>
            <th>Descrição</th>
            <th>Valor R$</th>
            <th>Quantidade</th>
            <th>Data</th>
            <th>Ações</th>
          </tr>
        </thead>

        <tbody>
        <?php while($despesa = mysqli_fetch_assoc($resultado_despesas)){
          ?>
          <tr class="linha">


            <td><?php echo $despesa['id']; ?></td>
            <td><?php echo $despesa['nome_despesa']; ?></td>
            <td><?php echo $despesa['descricao']; ?></td>
            <td><?php echo formata_moeda($despesa['valor']); ?></td>
            <td><?php echo $despesa['quantidade']; ?></td>
            <td><?php echo date("d/m/Y", strtotime($despesa['data'])); ?></td>
            <td>
            <button type="button" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#exampleModal"
                data-coddespesas="<?php echo $despesa['id']; ?>"
                data-nome="<?php echo $despesa['nome_despesa']; ?>"
                data-descricao="<?php echo $despesa['descricao']; ?>"
                data-valor="<?php echo formata_moeda($despesa['valor']); ?>"
                data-quantidade="<?php echo $despesa['quantidade']; ?>"
                data-data="<?php echo date("d/m/Y", strtotime($despesa['data'])); ?>">
                Editar
            </button>
            <a  href="javascript:m(); function m(){ modal({
                      type: 'confirm',
                      title: 'Confimação',
                      text: 'Tem certeza que deseja excluir esta despesa?',
                      buttonText: {
                        yes: 'Confirmar',
                        cancel: 'Cancelar'
                      },
                      callback: function(result) {
                        $('.modal-btn').attr('style', 'display: none !important');
                        if(result==true){
                        location.href='despesas_excluir.php?desp=<?php echo $despesa['id']?>'
                      }

                    }
                    }); $('.modal-btn').attr('style', 'display: inline !important'); };" class="btn btn-xs btn-danger"">Excluir</a>
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
                <a href="despesas.php?pagina=<?php echo $pagina_anterior; ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
          <?php }else{ ?>
              <span aria-hidden="true">&laquo;</span>
            <?php } ?>
            </li>

            <?php
              for($i = 1;  $i < $num_pg + 1; $i++){ ?>
                <li><a href="despesas.php?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
            <?php } ?>

            <li>
            <?php
              if($pagina_posterior <= $num_pg){ ?>
                <a href="despesas.php?pagina=<?php echo $pagina_posterior; ?>" aria-label="Previous">
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
            <form method="POST" action="despesas.php">
              <div class="form-group">
                <label for="despesa-name" class="control-label">Nome *</label>
                <input type="text" class="form-control" id="despesa-name" name="nome" required="requiored">
              </div>
              <div class="form-group">
                <label for="descricao-name" class="control-label">Descrição </label>
                <textarea class="form-control" id="descricao-name" name="descricao"></textarea>
              </div>

              <div class="row">
          <div class="form-group col-md-8">
            <label for="valor-name" class="control-label">Valor R$ *</label>
          <input type="text" autofocus class="form-control ValoresItens" data-affixes-stay="true" data-prefix="R$ " data-thousands="." data-decimal="," id="valor-name" name="valor" placeholder="Valor R$" required="requiored">
          </div>

          <div class="form-group col-md-4">
            <label for="quantidade-name" class="control-label">Quantidade *</label>
          <input type="text" class="form-control" id="quantidade-name" name="quantidade" required="requiored">
          </div>

           </div>

          <div class="input-group date">
            <label for="data-name" class="control-label">Data *</label>
          <input type="text" class="form-control data1 batata" id="data-name" name="data" required="requiored">
          </div>
          <br />

              <input name="id" type="hidden" id="cod-investimento">

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary" name="editar">Alterar</button>
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
        var recipientnome = button.data('nome') // Extract info from data-* attributes
        var recipientcod = button.data('coddespesas')
        var recipientdescricao = button.data('descricao')
        var recipientvalor = button.data('valor')
        var recipientquantidade = button.data('quantidade')
        var recipientdata = button.data('data')

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Editar -  Despesa #' + recipientcod)
        modal.find('#cod-investimento').val(recipientcod)
        modal.find('#despesa-name').val(recipientnome)
        modal.find('#descricao-name').val(recipientdescricao)
        modal.find('#valor-name').val(recipientvalor)
        modal.find('#quantidade-name').val(recipientquantidade)
        modal.find('#data-name').val(recipientdata)
      })
    </script>

    <?php
      function registraDespesa(){
          $nome = $_POST['nome'];
          $descricao = $_POST['descricao'];
          $valor = $_POST['valor'];

          $quant = $_POST['quant'];

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
          $valor=moeda_clean($valor);
          $sql = "insert into despesas(nome_despesa, descricao, quantidade, data, valor, proprietarios_id) values ('$nome', '$descricao', '$quant', '$data1', '$valor', '$id') ";

          //executar a query
          mysqli_query($link, $sql);

          if($sql){
            echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=despesas.php'>
            <script type=\"text/javascript\">

             $(window).load(function() {
                 modal({
                 type: 'success',
                 title: 'Sucesso',
                 text: 'Despesa registrada!',
                 autoclose: false,
                 size: 'large',
                 center: false,
                 theme: 'atlant',
                });
              });
            </script>
            ";
          }
          else{
            echo "
            <META HTTP-EQUI=REFRESH CONTENT = '2;URL=despesas.php'>
            <script type=\"text/javascript\">
              $(window).load(function() {
                 modal({
                 type: 'error',
                 title: 'Erro',
                 text: 'Não foi possível registrar a despesa!',
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
          registraDespesa();
      }

      function editarDespesa(){
        $cod = $_POST['id'];
        $nome = $_POST['nome'];
        $descricao = $_POST['descricao'];
        $valor = $_POST['valor'];
        $quantidade = $_POST['quantidade'];


        $data = str_replace("/", "-", $_POST["data"]);
        $data1 = date('Y-m-d', strtotime($data));

        $objBd = new bd();
        $link = $objBd->conecta_mysql();
        require_once('funcoes.php');
        $valor=moeda_clean($valor);
        $sql = " UPDATE despesas SET nome_despesa = '$nome', descricao = '$descricao', quantidade = '$quantidade', data = '$data1', valor = '$valor'
              WHERE id = '$cod' ";
        $resultado = mysqli_query($link, $sql);
        if(mysqli_affected_rows($link) != 0){
          echo "
            <META HTTP-EQUIV=REFRESH CONTENT = '2;URL=despesas.php'>
            <script type=\"text/javascript\">

             $(window).load(function() {
                 modal({
                 type: 'success',
                 title: 'Sucesso',
                 text: 'Despesa alterada com sucesso!',
                 autoclose: false,
                 size: 'large',
                 center: false,
                 theme: 'atlant',
                });
              });


            </script>";
        }else{
          echo "
            <META HTTP-EQUI=REFRESH CONTENT = '3;URL=despesas.php'>
            <script type=\"text/javascript\">
              $(window).load(function() {
                 modal({
                 type: 'error',
                 title: 'Error',
                 text: 'Despesa não pode ser alterada!',
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
        editarDespesa();
      }
    ?>

  </body>
</html>
