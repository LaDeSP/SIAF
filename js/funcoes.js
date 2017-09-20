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

$( ".ValoresItens" ).keyup(function() {
  alert( "Handler for .keyup() called." );
});


$(".ValoresItens").keyup(function()
{
  console.log("aa");
     $(".ValoresItens").maskMoney({
         prefix: "R$:",
         decimal: ",",
         thousands: "."
     });
});
