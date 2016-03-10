<?php
include("config/config.php");
$cache = new Cache();

$existe_em_cache = $cache->check();
if ($existe_em_cache != 0) {
    echo $existe_em_cache;
}
else
{
$cache->start();
?>

<html>
<head>
<title>Caching server output</title>
</head>
<body>
<h2>This page is a cached Page</h2>


<?php

echo "<hr>" . time();

$cache->stop();

}

?>

<?php
    $lv_strFile = $_SERVER["PHP_SELF"] . $_SERVER["QUERY_STRING"];
    
    //$str = ereg_replace('(w)', '\\1', $str);
    $lv_strFile = preg_replace("/([^a-zA-Z0-9])/",'_',$lv_strFile);
    // This will be 'foo o' now

    echo "<hr>";
    echo $lv_strFile;

?>

<?php echo "<hr>" . time();?>
</body>
</html>