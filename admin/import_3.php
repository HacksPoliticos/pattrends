<?php
include("../config/config.php");
include("function.criatags.php");


$time_start = microtime(true);


$dados = new Dados();

$sql = "
        SELECT patents.id, patents.date, patent_tags.id_patent, count(patent_tags.id_patent) as qtdde
        FROM patents
        LEFT JOIN patent_tags ON (patents.id = patent_tags.id_patent)
        GROUP BY (patents.id)
        HAVING count(patent_tags.id_patent) = 0
        LIMIT 10
        ";
/*       
$sql = "
        SELECT patents.id, patents.date
        FROM patents
        ";
*/
$patents = $dados->select($sql);

foreach($patents as $p)
{
    
        $numero_patente = $p["id"];
        $date           = $p["date"];
        
        $pt = new Patents();
        $pt->retrieve($numero_patente);
        $claims         = $pt->claims;
        $description    = $pt->description;
        $abstract       = $pt->abstract;
        
            $array_patente['description_tags'] = criatags($description);
            $array_patente['claims_tags']      = criatags($claims);
            $array_patente["abstract_tags"]    = criatags($abstract);
            
            $description_tags = $array_patente["description_tags"];
            if(count($description_tags) > 0)
            {
                foreach($description_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
        
                        $description_tags = new PatentTags();
                        $description_tags->create($numero_patente, $id_tag, $date, $weight, "description");
                        unset($description_tags);
                        
                    unset($tag);
                }
            }
        
            $claims_tags      = $array_patente["claims_tags"];
            if(count($claims_tags) > 0)
            {
                foreach($claims_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
                    
                        $claims_tags = new PatentTags();
                        $claims_tags->create($numero_patente, $id_tag, $date, $weight, "claims");
                        unset($claims_tags);
                        
                    unset($tag);
                }
            }
            
            $abstract_tags    = $array_patente["abstract_tags"];
            if(count($abstract_tags) > 0)
            {
                foreach($abstract_tags as $t)
                {
                    $tag = new Tags();
                    $id_tag  = $tag->get_id($t[0]);
                    $weight  = $t[1];
                    
                        $abstract_tags = new PatentTags();
                        $abstract_tags->create($numero_patente, $id_tag, $date, $weight, "abstract");
                        unset($abstract_tags);
                        
                    unset($tag);
                }
            }
            unset ($pt);
            unset($array_patente);
}

################################################################################

$time_end = microtime(true);
$time = ceil(($time_end - $time_start));


echo "<hr />";
echo "time: $time seconds<br />";
echo "memory_get_usage: " . round((memory_get_usage() / 1024 / 1024),2) . " Mbytes <br />";
echo "memory_get_peak_usage: " . round((memory_get_peak_usage() / 1024 / 1024),2) . " Mbytes <br />";

?>
