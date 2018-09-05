/*ajax busca data aual do servidor */
$(document).ready( function() {
  autoDate();

  el=$(".data");
  el.each(function(e){
    $(this).datepicker({language: 'pt-BR' } );

  });

  $('.data').focusout(function(){
    autoDate();
  });

});


function autoDate(){
  el=$(".data")
  el.each(function(e){
  var date=this.value;
  that=this;
  var url=window.location.href;
  var urlbase=url.substr(0,url.lastIndexOf('/'));
  url=urlbase+'/service_data.php';
  if(date===""){
    $.ajax( {
      type:'Get',
      url:url,
      success:function(dado) {
      that.value=dado.data;
    }

  });
  }

  });


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
