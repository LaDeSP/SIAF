/*ajax busca data aual do servidor */
$(document).ready( function() {
  var data=$("#data")[0].value
  if(data===""){
    $.ajax( {
      type:'Get',
      url:'http://localhost/SIAF/service_data.php',
      success:function(dado) {
      $("#data")[0].value=dado.data;
    }

  });
  }
});



$( document ).ready(function() {
  $(".ValoresItens").maskMoney({
      prefix: "R$:",
      decimal: ",",
      thousands: "."
  });
  //
  $(".ValoresItens")[0].focus();

  $('.modal').bind('display', function(e) {
      alert("display has changed to :" + $(this).attr('style') );
  });

});
