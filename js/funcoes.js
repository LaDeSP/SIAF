/*ajax busca data aual do servidor */
$(document).ready( function() {
  autoDate();

  $("input,button").not('#data').focusin(function(){
    autoDate();
  });

});


function autoDate(){
  if($("#data")[0]){
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
  $('#data').datepicker({format: 'dd/mm/yyyy'});
  }
}


$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return decodeURI(results[1]) || 0;
    }
}




$(window).load(function(){
  if($.urlParam("type")){
    modal({
                 type: decodeURIComponent($.urlParam("type")),
                 title: $.urlParam("title"),
                 text: $.urlParam("text"),
                 autoclose: true,
                 size: 'large',
                 center: false,
                 theme: 'atlant',
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
  if($(".ValoresItens")[0])
    $(".ValoresItens")[0].focus();

  $('.modal').bind('display', function(e) {
      alert("display has changed to :" + $(this).attr('style') );
  });

});
