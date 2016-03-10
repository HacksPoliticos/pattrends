<?php 
include("../config/config.php");

if(@$_GET['id'] != "")
{
    $stopword = new Stopwords();
    $stopword->delete($_GET['id']);
}

header("Location: stopwords.php");
?>
