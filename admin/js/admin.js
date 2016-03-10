$(document).ready(function()	{

    $("#div_ajax").hide();
    
    $(".delete").click(function () {
      if(!confirm("Tem certeza que deseja apagar?")){
            return false;
            }
    });
    
    $(".ajax").click(function () {
      if(!confirm("Tem certeza?")){
            return false;
            }
      else
      {
        $("#div_ajax_conteudo").load($(this).attr("href"));
        return false;
      }
    });
    
    $(".ajax").ajaxStart(function(){
      $("#div_ajax").show();
      $("#div_ajax_image").show();
    });
    
    $(".ajax").ajaxStop(function(){
      $("#div_ajax_image").hide();
    });
    
    $("#div_ajax_close").click(function(){
      $("#div_ajax").hide();
    });


    
});
