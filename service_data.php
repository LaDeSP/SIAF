<?php
/* serviço de data */
 $json = array("data" => date("Y-m-d"));
 header('Content-type: application/json');
 echo json_encode($json);
 ?>
