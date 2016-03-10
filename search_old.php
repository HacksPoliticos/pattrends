<?php
include("config/config.php");
include("function.criatagclouds.php");
include("function.printtagclouds.php");

$time_start = microtime(true);
?>
<html>
<head>
    <title>Pattrends</title>
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
    <script>
    $(document).ready(function(){
        
          $(".tag").click(function() {
            q = $(this).html();
            $(".resultado").load("search.php", "q="+q);
            return false;
          });
          
          $(".tag").dblclick(function() {
            //$(".tag").click();
            return false;
          });
        
          $("form").submit(function() {
            q = $("#q").val();
            $(".resultado").load("search.php", "q="+q);
            return false;
          });

    });
    </script>
</head>
<body>
<div class="resultado">
    <?php
    $cache = new Cache();

    $existe_em_cache = $cache->check();
    
    if ($existe_em_cache == 0)
    {
    //$cache->start();
    ?>
    <form action="search.php" style="margin-top:40px; margin-bottom:10px;" class="ajax">
        <input type="text" name="q" id="q" value="<?php echo @$_GET["q"];?>" style="width:60%;" />
        <input type="text" name="a" id="a" value="<?php echo @$_GET["a"];?>" style="width:39%;" /><br />
        <input type="submit" value="Search" style="width:32%; float:right;" />
        <input type="text" name="date_s" value="<?php echo @$_GET["date_s"];?>" style="width:32%;" />
        <input type="text" name="date_e" value="<?php echo @$_GET["date_e"];?>" style="width:32%;" />
        
    </form>
    
<?php
$date_start = @$_GET['date_s'];
$date_end   = @$_GET['date_e'];

if($date_start == "")
{
    $timestamp  = mktime(0, 0, 0, date("m")  , date("d")-320, date("Y"));
    $date_start = date("Ymd", $timestamp);
}

if($date_end == "")
{
    $date_end = date("Ymd");
}

$dados = new Dados();

$q = @$_GET["q"];
if($q != "")
{
    $tag = new Tags();
    
    if (strpos($q, ","))
    {
        $where = " 1=0 ";
        foreach(explode(",", $q) as $w)
        {
            $q_id = $tag->get_id(trim($w), 0);
            $where .= " OR id_tag = $q_id";
        }
    }
    else
    {
        $q_id = $tag->get_id($q, 0);
        $where = "id_tag = $q_id";
    }
        
    $sql = "
        SELECT patents.id, patent_tags.id_patent, patent_tags.id_tag
        FROM patent_tags
        JOIN patents ON (patents.id = patent_tags.id_patent)
        WHERE $where
        GROUP BY patents.id
        LIMIT 100
        ";
        
    //AQUI EU TENHO UM ARRAY COM AS PATENTES ONDE ESSE $q APARECE
    $patents = $dados->select($sql);
    
    $where = " AND ( 1=0 ";
    foreach($patents as $p)
    {
        $where .= " OR patents.id = '" . $p['id'] . "' ";    
    }
    $where .= " )";
    
    
    $sql = "
        SELECT patents.id as id_patent, patent_tags.id_tag, SUM(patent_tags.weight) AS weight, tags.name
        FROM patents
        JOIN patent_tags ON (patents.id = patent_tags.id_patent)
        JOIN tags ON (id_tag = tags.id)
        WHERE patents.date >= $date_start AND  patents.date <= $date_end
        $where
        GROUP BY (name)
        ORDER BY weight DESC
        LIMIT 100
        ";

    $patents = $dados->select($sql);
    
    
}

else
{
    $sql = "
        SELECT patents.id as id_patent, patent_tags.id_tag, SUM(patent_tags.weight) AS weight, tags.name
        FROM patents
        JOIN patent_tags ON (patents.id = patent_tags.id_patent)
        JOIN tags ON (id_tag = tags.id)
        WHERE patents.date >= $date_start AND  patents.date <= $date_end
        GROUP BY (name)
        ORDER BY weight DESC
        LIMIT 100
        ";
        
    $patents = $dados->select($sql);
}

//print_r($patents);


####################

printTagCloud($patents);

########################

    $where = " AND ( 1=0 ";
    foreach($patents as $p)
    {
        $where .= " OR patents.id = '" . $p['id_patent'] . "' ";    
    }
    $where .= " )";
    $sql = "
        SELECT id, title, abstract
        FROM patents
        WHERE patents.date >= $date_start AND  patents.date <= $date_end
        $where
        LIMIT 10
        ";
    $patents = $dados->select($sql);
    
    foreach($patents as $p)
    {
        echo "<div>";
        echo "<h2><a href=\"patent.php?id=" . $p['id'] . "\">" . $p['title'] . "</a></h2>";
        echo "<p>" . $p['abstract'] . "</p>";
        echo "</div>";
    }
//$cache->stop();
}
?>
<?php
$time_end = microtime(true);
$time = ceil(($time_end - $time_start));


echo "<hr /><pre>";
echo "time: $time seconds<br />";
echo "memory_get_usage: " . round((memory_get_usage() / 1024 / 1024),2) . " Mbytes \n";
echo "memory_get_peak_usage: " . round((memory_get_peak_usage() / 1024 / 1024),2) . " Mbytes \n";
echo "\n\n</pre>";
?>
</div>
</body>
</html>