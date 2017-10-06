<?php
/* serviço de data */
 date_default_timezone_set('America/Sao_Paulo');
 $json = array("data" => date("Y-m-d"));
 header('Content-type: application/json');
 echo json_encode($json);
 ?>
