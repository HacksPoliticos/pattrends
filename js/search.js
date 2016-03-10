function fazAjax(q,a,ds,de,tgt) {
    //q = tag
    //a = assignee
    //ds = date start
    //de = date end
    //tgt = div target
    
    ds = $("#ds").val();
    de = $("#de").val();
    
    //mostra o LOADING
    $("#loading").fadeIn('fast');
    
    //faz o request
    //$(".resultado")
    tgt.load("search.php", "ajax=1&q="+q+"&a="+a+"&ds="+ds+"&de="+de, function(){
        acertaAjax();
      });
    
}

function acertaAjax()
{
    if(typeof(q) != 'string')
    {
        q = "";
    }
    
    if(typeof(a) != 'string')
    {
        a = "";
    }
    
    if(typeof(ds) != 'string')
    {
        ds = "";
    }
    
    if(typeof(de) != 'string')
    {
        de = "";
    }

    
    $(".close").click(function() {
        $(this).parent("div").parent("div").remove();
        ajustaLargura();
        if($("#resultados > div").size() == 1)
        {
            $(".close").css("visibility", "hidden");
            $("#resultados").removeClass("resultado_slim");
        }
        
        return false;
    });
    
    $(".tag").click(function() {
        q = $(this).html();
        tgt = $(this).parent("div").parent("div");
        fazAjax(q,a,ds,de,tgt);
        return false;
    });
    
    $(".tag").dblclick(function() {
        return false;
    });
    
    
    $(".assignee").click(function() {
        a = $(this).html();
        tgt = $(this).parent("div").parent("div");
        fazAjax(q,a,ds,de,tgt);
        return false;
    });
    
    $(".assignee").dblclick(function() {
        return false;
    });
  
    $("form").submit(function() {
        q = $("#q").val();
        a = $("#a").val();
        ds = $("#ds").val();
        de = $("#de").val();
        tgt = $(this).parent("div").parent("div");
        
        fazAjax(q,a,ds,de,tgt);
        return false;
    });
    
    $(".date").datepicker({dateFormat: "mm/dd/yy"});
    
    $(".compare").click(function() {
      $.get("search.php", "ajax=1&q=", function(data){
        $("#resultados").append("<div class=\"resultado\">"+data+"</div>");
        acertaAjax();
        $("#resultados").addClass("resultado_slim");
        //$(".close").show("fast");
        ajustaLargura();
        });   
    });
    
    $(".compare").dblclick(function() {
        return false;
    });
    
    ajustaLargura();
    $("#loading").fadeOut('fast');
    
    $(".q").focus(function() {
        if($(this).val() == "TAGS")
        {
            $(this).val("");
        }
    });
    
    $(".q").blur(function() {
        if($(this).val() == "")
        {
            $(this).val("TAGS");
        }
    });
    
    $(".a").focus(function() {
        if($(this).val() == "CORPS")
        {
            $(this).val("");
        }
    });
    
    $(".a").blur(function() {
        if($(this).val() == "")
        {
            $(this).val("CORPS");
        }
    });
    
    
}

function ajustaLargura()
{
    largura = $(".resultado").width() + 50;
    quantidade = $("#resultados > div").size();
    
    if(quantidade == 1)
    {
        $(".close").css("visibility", "hidden");
    }
    else
    {
        $(".close").css("visibility", "visible");
    }
    tamanho = (quantidade*largura);
        if(tamanho < 1024)
        {
            tamanho = 1024;
        }
    $("#resultados").width( tamanho + "px");
}

$(document).ready(function(){
  
  acertaAjax();
    
    
    $("#reset").click(function() {
      $("#resultados").load("search.php .resultado", "&q=", function(){
        acertaAjax();
        $("#resultados").removeClass("resultado_slim");
        ajustaLargura();
      }); 
    });
    
  
});