<?php
include("../config/config.php");

$time_start = microtime(true);

$dados = new Dados();

$sql = "
        SELECT id, description
        FROM patents
        WHERE description = ''
        AND date > 20070721
        ORDER BY date DESC
        ";
        // OR claims = ''

$patents = $dados->select($sql);

foreach($patents as $p)
{
    $numero_patente = $p["id"];
    
    echo "$numero_patente <br />";
    
    $url_externo = "http://patft.uspto.gov/netacgi/nph-Parser?Sect1=PTO2&Sect2=HITOFF&p=1&u=%2Fnetahtml%2FPTO%2Fsearch-adv.htm&r=1&f=G&l=50&d=PALL&S1=" . $numero_patente . "&OS=" . $numero_patente . "&RS=" . $numero_patente;
            
            echo "numero da patente: <a href=\"" . $url_externo . "\" target=\"_blank\">" . $numero_patente . "</a><br />";
            //echo $numero_patente;
            
            //AGORA EU PEGO OS DADOS DAQUELE SITE DO GOVERNO
            $dados_externos = file_get_contents($url_externo);
            
            //echo "DESCRIPTION\n\n";
            // <CENTER><B><I> Description</B></I></CENTER> 
            $array_dados_externos = explode("Description</B></I></CENTER>", $dados_externos);
            $description = $array_dados_externos[1];
            $description = explode("<HR>", $description);
            $description = $description[1];
            $description = trim(strip_tags($description));
            
            $array_patente['description'] = $description;
            
            
            
            //echo "\n\nCLAIMS\n\n";
            $array_dados_externos = explode("<CENTER><B><I>Claims</B></I></CENTER> ", $dados_externos);
            $claims = $array_dados_externos[1];
            $claims = explode("<HR>", $claims);
            $claims = $claims[1];
            $claims = trim(strip_tags($claims));
            
            $array_patente['claims'] = $claims;
            
            unset($array_dados_externos);
            
    $patent = new Patents();
    $patent->update($numero_patente, $array_patente['claims'], $array_patente['description']);
    


    
        unset($patent);
        unset($array_patente);
}

    

#############################################################################################################
$time_end = microtime(true);
$time = ceil(($time_end - $time_start));


echo "<hr />";
echo "time: $time seconds<br />";
echo "memory_get_usage: " . round((memory_get_usage() / 1024 / 1024),2) . " Mbytes <br />";
echo "memory_get_peak_usage: " . round((memory_get_peak_usage() / 1024 / 1024),2) . " Mbytes <br />";
?>