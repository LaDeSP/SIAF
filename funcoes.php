<?php
function moeda_clean($value){

  $value=str_replace('.', '', $value);
  $value=str_replace(',', '.', $value);
  return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

function formata_moeda($value){
  try{
      setlocale(LC_MONETARY, 'pt_BR.UTF-8');
      return money_format('%n', $value);
  }catch (\Exception $e){
    return $value;
  }
}
function formata_data($data){
  $data = str_replace("/", "-", $data);
  return date('Y-m-d', strtotime($data));
}
 ?>
