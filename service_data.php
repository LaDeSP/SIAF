<?php
/* serviço de data */
 date_default_timezone_set('America/Sao_Paulo');
 $json = array("data" => str_replace("-", "/", date("d-m-Y")) );
 header('Content-type: application/json');
 echo json_encode($json);
 ?>
