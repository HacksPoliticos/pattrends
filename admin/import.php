<?php
include("../config/config.php");
include("inc/cabecalho.php");
?>

<h1>Step 1</h1>
<p>Baixa, descompacta e importa os dados do governo gringo para o banco de dados</p>

<div id="import_list">
    
    <?php
    
    $path = XML_PATH;
    
    $timestamp_inicial  = mktime(9, 0, 0, 01, 06, 2009);
    $timestamp_hoje  = mktime(date("H"), 0, 0, date("m")  , date("d"), date("Y"));
    $segundos = $timestamp_hoje - $timestamp_inicial;
    $arquivos = floor($segundos / 60 / 60 / 24 / 7) + 1;
    
    
    function descompacta($arquivo)
    {
         $zip = new ZipArchive;
         $res = $zip->open($arquivo);
         if ($res === TRUE) {
             $zip->extractTo('xml');
             $zip->close();
             return 1;
         } else {
             return 0;
         }
    }
    
    for($wk = $arquivos; $wk >= 1; $wk--)
    {
        
        if(strlen($wk) == 1)
        {
            $wk = 0 . $wk;
        }
        
        if(($wk % 2) == 0)
        {
            $color = "#EEEEEE";
        }
        else
        {
            $color = "#FFFFFF";
        }
        
        echo "<div id=\"wk$wk\" style=\"background-color:$color;\">";
        $date = date( "Ymd" , mktime(9, 0, 0, 01, (06 + (7* ($wk - 1))), 2009));
        
        $filename = "ipgb" . $date . "_wk" . $wk . ".zip";
        $txt      = "ipgb" . $date . "lst.txt";
        $xml      = "ipgb" . $date . ".xml";
        
        $url = "https://eipweb.uspto.gov/2009/PatentGrantBibICEXML/" . $filename;
        
        echo "week: " . $wk . " - ";
        
        if(!file_exists($path . $filename))
        {
            echo "<a href=\"import_download.php?filename=".urlencode($filename)."&url=".urlencode($url)."\" class=\"icons down ajax\" title=\"click to download\"><span>download</span></a>";
            
            /* vou colocar no import_download.php
            if(@$_GET['download'] == $wk)
            {
            $data = $file = file_get_contents($url);
            
            $fp = fopen($path.'/'.$filename, "w", 0); #open for writing
              fputs($fp, $data); #write all of $data to our opened file
              fclose($fp); #close the file
            
            descompacta($path . $filename);
            
            }
            */
            
            
        }
        else
        {
            echo "<a href=\"import_download.php?filename=".urlencode($filename)."&url=".urlencode($url)."\" class=\"icons tick ajax\" title=\"click to re-download\"><span>download</span></a>";
            echo "<a href=\"import.php?unzip=$wk#wk$wk\" class=\"icons compress\" title=\"unzip\"><span>compress</span></a>";
            
            
            
            if(@$_GET['unzip'] == $wk)
            {            
                descompacta($path . $filename);
            }
            
            if(file_exists($path . $xml))
            {
                //ABRE O ARQUIVO DE TEXT PEGA A PRIMEIRA E ULTIMA PATENTE E VEREFICA SE ELAS ESTAO NO BANCO DE DADOS
                $fh_txt = file($path . $txt);
                
                $patents = new Patents();
                
                
                if($patents->exists(trim($fh_txt[0])) && $patents->exists(trim($fh_txt[count($fh_txt) - 1])))
                {
                    //echo "<a href=\"import_1.php?file=" . $xml . "\" class=\"icons database\" title=\"click insert row into database\"><span>database</span></a>";
                    echo "<a class=\"icons database\" title=\"everything already on database\"><span>database</span></a>";
                }
                else
                {
                    echo "<a href=\"import_1.php?file=" . $xml . "#wk$wk\" class=\"icons database_error ajax\" title=\"click insert row into database\"><span>database</span></a>";
                }
                unset($patents);
                unset($fh_txt);
            }

            
            
        }
        
        
        echo "</div>";
    }
    
    
    ?> 
    
    
</div>

<br />

<h1><a href="import_2.php" target="_blank" class="ajax">Step 2</a></h1>
<p>Pega os conteúdo dos campos <em>claims</em> e <em>description</em> do <a href="http://patft.uspto.gov/" target="_blank">http://patft.uspto.gov/</a></p>
<br />

<h1><a href="import_3.php" target="_blank" class="ajax">Step 3</a></h1>
<p>Cria os tags dos campos <em>abstract</em>, <em>claims</em> e <em>description</em> das patentes que não possuem nenhum tag</p>
<p>NUNCA faça o passo 3 sem fazer o 2! (por causa do abstract)</p>
<br />
<?php
include("inc/rodape.php");
?>
