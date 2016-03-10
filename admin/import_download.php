<?php
include("../config/config.php");

$path     = XML_PATH;
$url      = urldecode(@$_GET['url']);
$filename = urldecode(@$_GET['filename']);

    if($url != "")
    {
    $data = $file = file_get_contents($url);
    
    $fp = fopen($path.'/'.$filename, "w", 0); #open for writing
      fputs($fp, $data); #write all of $data to our opened file
      fclose($fp); #close the file
      echo $filename . " downloaded! <a href='?'>refresh</a>";
    }
    else
    {
      echo "Ahhh! nao to afim de baixar este arquivo";
    }
?>