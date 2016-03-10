<?php
include("config/config.php");

$benchmark = new Benchmark();

include("function.criatagclouds.php");
include("function.printtagclouds.php");

include('lib/dwoo/dwooAutoload.php'); 
$dwoo = new Dwoo();
if(@$_GET['ajax'] == "1")
    {
    $tpl  = new Dwoo_Template_File('templates/search_ajax.tpl'); 
    }
else
    {
    $tpl  = new Dwoo_Template_File('templates/search.tpl'); 
    }
$data = new Dwoo_Data();

$cache = new Cache();
$existe_em_cache = $cache->check();
if ($existe_em_cache == 0)
{
$cache->start();

//PEGANDO AS QUERY STRINGS
function limpaVariavel($variavel)
{
    return (htmlspecialchars(strip_tags($variavel)));
}

$date_start = limpaVariavel(@$_GET['ds']);
$date_end   = limpaVariavel(@$_GET['de']);
$q          = limpaVariavel(@$_GET["q"]);
$a          = limpaVariavel(@$_GET["a"]);

//ACERTANDO AS DATAS


if($date_start == "")
{
    $timestamp  = mktime(0, 0, 0, date("m") - 15 , date("d"), date("Y"));
    $date_start = date("Ymd", $timestamp);
}
else
{
    $date_s_array = explode("/", $date_start);
    $date_start = $date_s_array[2].$date_s_array[0].$date_s_array[1];
}

if($date_end == "")
{
    $date_end = date("Ymd");
}
else
{
    $date_e_array = explode("/", $date_end);
    $date_end = $date_e_array[2].$date_e_array[0].$date_e_array[1];
}
//FIM ACERTANDO AS DATAS

$dados = new Dados();

//TRATA q & a
    
    $where = "";
    if($q != "" && $q != "TAGS")
    {
        $tag = new Tags();
        
        if (strpos($q, ","))
        {
            $where = " WHERE 1=0 ";
            foreach(explode(",", $q) as $w)
            {
                $q_id = $tag->get_id(trim($w), 0);
                $where .= " OR id_tag = $q_id";
            }
        }
        else
        {
            $q_id = $tag->get_id($q, 0);
            $where = " WHERE id_tag = $q_id";
            
            //GRAFICOS!!!!
                $sql_graph = "
                    SELECT id_tag, id_patent, date, COUNT(date) as qtdde
                    FROM patent_tags
                    WHERE id_tag = $q_id
                    GROUP BY (date)
                    ";
                $grafico = $dados->select($sql_graph);
                $data->assign('grafico', $grafico);
                //print_r($grafico);
            //FIM GRAFICOS
        }
        
            $sql = "
            SELECT patents.id, patent_tags.id_patent, patent_tags.id_tag, patents.appl_type
            FROM patent_tags
            JOIN patents ON (patents.id = patent_tags.id_patent)
            $where
            GROUP BY patents.id
            HAVING patents.appl_type <> 'design'
            LIMIT 100
            ";

            //echo "<hr>";
                
            //AQUI EU TENHO UM ARRAY COM AS PATENTES ONDE ESSE $q APARECE
            $patents = $dados->select($sql);
            
            $where = " AND ( 1=0 ";
            foreach($patents as $p)
            {
                $where .= " OR patent_tags.id_patent = '" . $p['id'] . "' ";    
            }
            $where .= " )";
    }
    
    $join = "";
    $join_field = "";
    if($a != "" && $a != "CORPS")
    {
        $assignee = new Assignees();
        
        $a_id = $assignee->get_id($a, 0);
        //$having = " HAVING assignee = $a_id";
        $where .= " AND patent_assignees.id_assignee = $a_id ";
        $join = " JOIN patent_assignees ON ( patent_tags.id_patent = patent_assignees.id_patent ) ";
        $join_field = ", patent_assignees.id_assignee AS assignee, patent_assignees.id_patent ";
        
            
            /*
        if (strpos($a, ","))
        {
            $having = " HAVING 1=0 ";
            foreach(explode(",", $a) as $w)
            {
                $a_id = $assignee->get_id(trim($w), 0);
                $having .= " OR id_assignee = $a_id";
            }
        }
        else
        {
            $a_id = $assignee->get_id($a, 0);
            $having = " HAVING id_assignee = $a_id";
        }
            */
    }


if($q != "" || $a != "" )
{
    
    /*
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
    */
    
    /* FUNCIONA!!!!
    SELECT patent_tags.id_patent AS id_patent, patent_tags.id_tag, SUM( patent_tags.weight ) AS weight, tags.name, patent_assignees.id_assignee AS assignee, patent_assignees.id_patent
    FROM patent_tags
    JOIN tags ON ( id_tag = tags.id )
    JOIN patent_assignees ON ( patent_tags.id_patent = patent_assignees.id_patent )
    WHERE patent_tags.date >=20080507
    AND patent_tags.date <=20090807
    AND patent_assignees.id_assignee =113
    GROUP BY (
    name
    )
    HAVING assignee =113
    ORDER BY weight DESC
    LIMIT 100
    */
    
    //PEGA AS TAGS
    $sql = "
        SELECT patent_tags.id_patent as id_patent, patent_tags.id_tag, SUM(patent_tags.weight) AS weight, tags.name  $join_field
        FROM patent_tags
        JOIN tags ON (id_tag = tags.id)
        $join
        WHERE patent_tags.date >= $date_start AND  patent_tags.date <= $date_end
        $where
        GROUP BY (name)
        ORDER BY weight DESC
        LIMIT 100
        ";
        
        //echo $sql;

    $tags = $dados->select($sql);
    
    
}
else //CASO NAO TENHA NEM q nem a
{       
    $sql = "
        SELECT patent_tags.id_patent as id_patent, patent_tags.id_tag, SUM(patent_tags.weight) AS weight, tags.name
        FROM patent_tags
        JOIN tags ON (id_tag = tags.id)
        WHERE patent_tags.date >= $date_start AND  patent_tags.date <= $date_end
        GROUP BY (name)
        ORDER BY weight DESC
        LIMIT 100
        ";
        //echo $sql;
        
    $tags = $dados->select($sql);
}

//print_r($patents);


####################

//printTagCloud($patents);

/******************************************************************************/
function retornaTagCloud($tags, $field1="name", $field2="weight", $max_size=60, $min_size=10, $max_tags=80) {
       
       if($max_tags > count($tags))
       {
        $max_tags = count($tags);
       }
        $max_qty = $tags[0][$field2];
        $min_qty = $tags[$max_tags - 1][$field2];
        
        //DA UMA EMBARALHADA NOS TRECO
       // shuffle($tags);
        
        $spread = $max_qty - $min_qty;
        if ($spread == 0) {
                $spread = 1;
        }
       
        $step = ($max_size - $min_size) / ($spread);
       
        $retorno = array();
        for($z=0; $z < $max_tags; $z++)
        {
            $size = round($min_size + (($tags[$z][$field2] - $min_qty) * $step));
            $retorno[] = array("name" => $tags[$z][$field1], "weight" => $tags[$z][$field2], "size" => $size);
        }
        /*
        foreach ($tags as $tag) {
                $size = round($min_size + (($tag[$field2] - $min_qty) * $step));
                $retorno[] = array("name" => $tag[$field1], "weight" => $tag[$field2], "size" => $size);
        }
        */
        return $retorno;
    
}
/******************************************************************************/
$data->assign('tags', retornaTagCloud($tags)); 

/* PATENTS */
    
    $where = "";
    if(count(@$patents) > 0)
    {
        $where = " AND ( 1=0 ";
        foreach($patents as $p)
        {
            $where .= " OR patents.id = '" . $p['id_patent'] . "' ";    
        }
        $where .= " )";
    }
    
    $sql = "
        SELECT id, title, abstract
        FROM patents
        WHERE patents.date >= $date_start AND  patents.date <= $date_end
        $where
        LIMIT 10
        ";
    $patents = $dados->select($sql);

    $data->assign('patents', $patents);
    
/* CORPS */

    $sql = "
        SELECT assignees.id, assignees.orgname, COUNT(patent_assignees.id_assignee) as qtdde
        FROM assignees
        JOIN patent_assignees ON (assignees.id = patent_assignees.id_assignee)
        GROUP BY (assignees.orgname)
        ORDER BY qtdde DESC
        LIMIT 40
        
        ";
    $assignees = $dados->select($sql);
    
    $data->assign('assignees', retornaTagCloud($assignees, "orgname", "qtdde", 20, 10, 10));
    
//    $data->assign('assignees', $assignees);



$data->assign('date_start', substr($date_start, 4,2) . "/" . substr($date_start, 6,2) . "/" . substr($date_start, 0,4) );
$data->assign('date_end', substr($date_end, 4,2) . "/" . substr($date_end, 6,2) . "/" . substr($date_end, 0,4) );
$data->assign('q', $q);
$data->assign('a', $a);


    
// Output the result ... 
$dwoo->output($tpl, $data); 
// ... or get it to use it somewhere else 
//$dwoo->get($tpl, $data);

$cache->stop();
}
//$benchmark->stop();
?>
